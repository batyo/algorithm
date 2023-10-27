<?php

require_once("../fordfulkerson_matrix.php");

// グラフの隣接行列

$node = 0; // 頂点数
$edge = 0; // 辺数
echo "Node Edge:";
fscanf(STDIN, "%d %d", $node, $edge);

$graph = array_fill(0, $node, array_fill(0, $node, 0));

for ($i = 0; $i < $edge; $i++) {
    $form = 0; // 辺の始点ノード
    $to = 0; // 辺の終点ノード
    $capacity = 0; // 容量
    echo "form to capacity:";
    fscanf(STDIN, "%d %d %d", $form, $to, $capacity);

    $graph[$form][$to] = $capacity;
}

// フォードファルカーソン法
$fordFulkerson = new FordFulkerson($graph);
$startNode = 0;
$endNode = $node-1;
$maxFlow = $fordFulkerson->maxFlow($startNode, $endNode);
echo "最大フロー: " . $maxFlow;