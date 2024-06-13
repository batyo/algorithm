<?php

require_once("../../twoPart_matching.php");


// グラフの隣接行列

$employeeCount = 0; // 従業員数
$shiftCount = 0; // シフト数

echo "Employee Shift:";
fscanf(STDIN, "%d %d", $employeeCount, $shiftCount);

$totalNumberNode = $employeeCount + $shiftCount + 2; // 始発・終着ノード分足す

$employeeCapacity = []; // 従業員の容量
$shiftCapacity = []; // シフトの容量

// 従業員の容量入力
for ($i = 1; $i <= $employeeCount; $i++) {
    echo "Enter the capacity of employee ".$i.":";
    fscanf(STDIN, "%d", $employeeCapacity[$i]);
}

// シフトの容量入力
for ($i = 1; $i <= $shiftCount; $i++) {
    echo "Enter the capacity of shift ".$i.":";
    fscanf(STDIN, "%d", $shiftCapacity[$i]);
}

// グラフの初期化
$graph = array_fill(0, $totalNumberNode, array_fill(0, $totalNumberNode, 0));
for ($employee = 1; $employee <= $employeeCount; $employee++) $graph[0][$employee] = $employeeCapacity[$employee]; // 始発ノード
for ($shift = 1; $shift <= $shiftCount; $shift++) {
    $graph[$shift+$employeeCount][$totalNumberNode-1] = $shiftCapacity[$shift]; // 終着ノード
}

// 優先順位グラフの初期化
$priority = array_fill(0, $totalNumberNode, array_fill(0, $totalNumberNode, -1));

// 優先順位の重複チェック
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
        echo "employee preferredShift priorityRank:";
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
$sortedEmployee = $matching->rearrangingNode($employeeCount, $shiftCount, $employeeCapacity);

echo print_r($matching->getGraph());

$maxFlow = $matching->maxMatch(0, $totalNumberNode-1, $employeeCount, $sortedEmployee);

// 更新されたグラフ(残余グラフ)
$afterGraph = $matching->getGraph();

//echo print_r($afterGraph);

// シフトマッチング結果
for ($shift = 1; $shift <= $shiftCount; $shift++) {
    for ($employee = 1; $employee <= $employeeCount; $employee++) {
        if ($afterGraph[$shift+$employeeCount][$employee] == 0) continue;
        echo "従業員{$sortedEmployee[$employee-1]} => シフト{$shift}".PHP_EOL;
    }
}

echo "最大マッチ数: " . $maxFlow;