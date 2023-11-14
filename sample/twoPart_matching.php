<?php

require_once("../fordfulkerson_matrix.php");

// フォードファルカーソン法を応用した二部グラフマッチング
// 「従業員」と「シフト」のマッチング

class Matching extends FordFulkerson
{
    private $priority; // 優先順位

    public function __construct($graph, $priority)
    {
        parent::__construct($graph);
        $this->priority = $priority;
    }

    /**
     * 従業員ノードを条件に従って並び替えるメソッド
     * 
     * 1. シフトの選択肢が少ない従業員のノードから探索するようにする
     * 2. 優先順位の高いノードにノード番号が小さいシフトを持つ従業員から探索するようにする
     *
     * @param int $employeeCount    従業員数
     * @param int $shiftCount       シフト数
     * 
     * @return array
     */
    public function rearrangingNode($employeeCount, $shiftCount)
    {
        // シフトの選択肢が少ない従業員のノードから探索するようにする
        $choiceCount_list = [];
        for ($employee = 1; $employee <= $employeeCount; $employee++) {
            $choiceCount = 0;
            for ($shift = 1; $shift <= $shiftCount; $shift++) {
                if ($this->graph[$employee][$shift+$employeeCount] == 1) $choiceCount++;;
                if ($shift == $shiftCount) $choiceCount_list[$employee] = $choiceCount;
            } 
        }

        asort($choiceCount_list);
        
        // 優先順位の高いノードにノード番号が小さいシフトを持つ従業員から探索するようにする
        $maxChoiceCount = max($choiceCount_list);
        $minChoiceCount = min($choiceCount_list);

        // 同じ選択肢数を持つノードごとに配列内でまとめる
        $setChoiceCount = [];
        $currentCount = 0;
        foreach ($choiceCount_list as $employee => $count) {
            // 優先順位が一番高いシフトのノード番号
            $mostPriprityNode = array_search(1, $this->priority[$employee]);

            if ($count != $currentCount) $currentCount = $count;

            $setChoiceCount[$currentCount][$employee] = [];
            array_push($setChoiceCount[$currentCount][$employee], $mostPriprityNode);
        }

        // 同じ選択肢数をもつ配列ごとに昇順ソートする
        $lastSort = [];
        for ($i = 0; $i+$minChoiceCount <= $maxChoiceCount; $i++) {
            asort($setChoiceCount[$i+$minChoiceCount]);

            foreach ($setChoiceCount[$i+$minChoiceCount] as $employee => $shift) {
                $lastSort[$employee] = [];
                array_push($lastSort[$employee], $shift[0]);
            }
        }

        $priorityOrder = array_keys($lastSort);

        // 並び替えた従業員に合わせたシフトをセットする
        $saveShift = [];
        for ($i = 1; $i <= count($priorityOrder); $i++) {
            $employeeNumber = $priorityOrder[$i-1];
            $saveShift[$i] = $this->graph[$i]; // 上書きする前に保存
            
            // シフト情報取得
            $shiftInfo;
            if (isset($saveShift[$employeeNumber])) $shiftInfo = $saveShift[$employeeNumber];
            if ( !isset($saveShift[$employeeNumber]) ) $shiftInfo = $this->graph[$employeeNumber];
            
            $this->graph[$i] = $shiftInfo;
        }
        
        return $priorityOrder;
    }
}


// グラフの隣接行列

$employeeCount = 0; // 従業員数
$shiftCount = 0; // シフト数

echo "Employee Shift:";
fscanf(STDIN, "%d %d", $employeeCount, $shiftCount);

$totalNumberNode = $employeeCount + $shiftCount + 2; // 始発・終着ノード分足す

// グラフの初期化
$graph = array_fill(0, $totalNumberNode, array_fill(0, $totalNumberNode, 0));
for ($employee = 1; $employee <= $employeeCount; $employee++) $graph[0][$employee] = 1; // 始発ノード
for ($shift = 1; $shift <= $shiftCount; $shift++) $graph[$shift+$employeeCount][$totalNumberNode-1] = 1; // 終着ノード

// 優先順位グラフの初期化
$priority = array_fill(0, $totalNumberNode, array_fill(0, $totalNumberNode, -1));

$priorityRankCheck = [];

// グラフ入力
while (true) {
    echo "---employee's preferred shift---".PHP_EOL;
    echo 'Enter "e" button to exit. Continue with the other buttons.:';
    $input = trim(fgets(STDIN));

    if ($input == "e") break;

    $employeeNumber = 0; // 従業員番号
    $preferredShift = 0; // 希望シフト
    $priorityRank = 0; // 希望シフトの優先順位

    $inputChecked = false;
    while ( !$inputChecked ) {
        echo "employee preferredShift:";
        fscanf(STDIN, "%d %d %d", $employeeNumber, $preferredShift, $priorityRank);

        if (isset($priorityRankCheck[$employeeNumber][$priorityRank])) {
            echo "That priority is already set. Please re-enter.".PHP_EOL;
            continue;
        }

        $inputChecked = true;
    }

    $priorityRankCheck[$employeeNumber][$priorityRank] = "set";

    $graph[$employeeNumber][$preferredShift] = 1;
    $priority[$employeeNumber][$preferredShift] = $priorityRank;
}


// フォードファルカーソン法
$matching = new Matching($graph, $priority);
$sortedEmployee = $matching->rearrangingNode($employeeCount, $shiftCount);
$maxFlow = $matching->maxFlow(0, $totalNumberNode-1);

// 更新されたグラフ(残余グラフ)
$afterGraph = $matching->getGraph();

// シフトマッチング結果
for ($shift = 1; $shift <= $shiftCount; $shift++) {
    for ($employee = 1; $employee <= $employeeCount; $employee++) {
        if ($afterGraph[$shift+$employeeCount][$employee] == 0) continue;
        echo "従業員{$sortedEmployee[$employee-1]} => シフト{$shift}".PHP_EOL;
    }
}

echo "最大マッチ数: " . $maxFlow;