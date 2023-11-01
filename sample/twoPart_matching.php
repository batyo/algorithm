<?php

require_once("../fordfulkerson_matrix.php");

// フォードファルカーソン法を応用した二部グラフマッチング
// 「従業員」と「シフト」のマッチング


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


while (true) {
    echo "---employee's preferred shift---".PHP_EOL;
    echo 'Enter "e" button to exit. Continue with the other buttons.:';
    $input = trim(fgets(STDIN));

    if ($input == "e") break;

    $employeeNumber = 0; // 従業員番号
    $preferredShift = 0; // 希望シフト
    echo "employee preferredShift:";
    fscanf(STDIN, "%d %d", $employeeNumber, $preferredShift);

    $graph[$employeeNumber][$preferredShift] = 1;
}


// フォードファルカーソン法
$fordFulkerson = new FordFulkerson($graph);
$maxFlow = $fordFulkerson->maxFlow(0, $totalNumberNode-1);

// 更新されたグラフ(残余グラフ)
$afterGraph = $fordFulkerson->getGraph();

// シフトマッチング結果
for ($shift = 1; $shift <= $shiftCount; $shift++) {
    for ($employee = 1; $employee <= $employeeCount; $employee++) {
        if ($afterGraph[$shift+$employeeCount][$employee] == 0) continue;
        echo "従業員{$employee} => シフト{$shift}".PHP_EOL;
    }
}

echo "最大マッチ数: " . $maxFlow;