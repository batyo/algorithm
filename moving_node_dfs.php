<?php

/**
 * ノードの移動 (深さ優先探索)
 *
 * @param array $adjacentList   隣接リスト
 * @param array $path           移動経路
 * @param int   $currentNode    現在のノード
 * @param int   $diceNumber     残り移動数
 * @param array $nodeRecord     ノードに記録された残り移動数    
 * 
 * @return array    $path   移動経路 $path[0] は空の状態でリターンされる
 */
function moving_node_dfs(&$adjacentList, &$path, $currentNode, $diceNumber, $nodeRecord)
{
    // 直近のノードが現在のノードと異なる場合 ... ノードを移動し経路に現在のノードを追加する
    $recentNode = $path[0][count($path[0])-1];
    if ($recentNode != $currentNode) array_push($path[0], $currentNode);

    // 残り移動数が 0 でない場合 ...　進んだノードに残り移動数を記録
    if ($diceNumber != 0) array_push($nodeRecord[$currentNode], $diceNumber);

    // 残り移動数が 0 になった場合 ... これまでの経路が記録された配列を $path 配列の最後尾に追加する
    else $path[count($path)] = $path[0];

    // 現在のノードから進行可能なノード
    $ProgressibleNodes = array_values($adjacentList[$currentNode]);
    
    for ($i = 0; $i < count($ProgressibleNodes); $i++) {

        // 折り返しの禁止とサイコロの目が 0 以下ならスキップ
        $lastNumberInNode = $nodeRecord[$ProgressibleNodes[$i]][count($nodeRecord[$ProgressibleNodes[$i]])-1];
        if ($lastNumberInNode == $diceNumber + 1 || $diceNumber <= 0) continue;

        moving_node_dfs($adjacentList, $path, $ProgressibleNodes[$i], $diceNumber-1, $nodeRecord);
    }

    // 前のノードに戻る前に現在のノードを移動経路から削除する
    array_pop($path[0]);

    return $path;
}
