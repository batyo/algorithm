<?php

require_once("../moving_node_dfs.php");

/**
 * [初期状態]
 * 
 * スタートするノードが 0 で、進める数が 5 である場合。
 * 
 * 
 * [ノード図]
 * 
 * [0]-[1]-[2]-[3]-[4]-[5]
 *  |   |
 * [6]-[7]-[8]
 * 
 */

$INF = 9999;

$adjacentList = [[1,6],[0,2,7],[1,3],[2,4],[3,5],[4],[0,7],[1,6,8],[7]];
$path = [[0]];
$currentNode = 0;
$diceNumber = 5;
$nodeRecord = [[$INF],[$INF],[$INF],[$INF],[$INF],[$INF],[$INF],[$INF],[$INF]];

moving_node_dfs($adjacentList, $path, $currentNode, $diceNumber, $nodeRecord);

array_shift($path);

echo print_r($path);

/**
 * Array
 * (
 *   [0] => Array
 *       (
 *           [0] => 0
 *           [1] => 1
 *           [2] => 2
 *           [3] => 3
 *           [4] => 4
 *           [5] => 5
 *       )
 *
 *   [1] => Array
 *       (
 *           [0] => 0
 *           [1] => 1
 *           [2] => 7
 *           [3] => 6
 *           [4] => 0
 *           [5] => 1
 *       )
 *
 *   [2] => Array
 *       (
 *           [0] => 0
 *           [1] => 6
 *           [2] => 7
 *           [3] => 1
 *           [4] => 0
 *           [5] => 6
 *       )
 *
 *   [3] => Array
 *       (
 *           [0] => 0
 *           [1] => 6
 *           [2] => 7
 *           [3] => 1
 *           [4] => 2
 *           [5] => 3
 *       )
 *
 *)
 *
 */