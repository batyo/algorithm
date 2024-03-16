<?php

/**
 * ダイクストラ法
 */
class Dijkstra
{
    /** @var int 無限 */
    const INF = PHP_INT_MAX;

    /**
     * 緩和を実施する関数
     *
     * @param int $a 緩和対象 (*参照渡し)
     * @param int $b 比較対象
     * 
     * @return true|false  緩和が実行されたか否か
     */
    private function chmin(&$a, $b)
    {
        if ($a > $b) {
            $a = $b;
            return true;
        }
        else return false;
    }

    /**
     * ダイクストラ法
     *
     * @param array $adjacentList   隣接リスト (*参照渡し)
     * @param int   $nodeCount      ノードの総数
     * @param int   $startNode      始発ノードの番号
     * @param array $dist           距離 (*参照渡し)
     * 
     * @return void
     */
    public function dijkstra(&$adjacentList, $nodeCount, $startNode, &$dist)
    {
        $INF = INF;

        $visited = array_fill(0, $nodeCount, false); // 訪問チェック
        $dist[$startNode] = 0; // 始点からの最短距離

        for ($iter = 0; $iter < $nodeCount; $iter++) {

            // 訪問済みでない頂点のうち dist 値が最小の頂点 min_v を探す
            $min_dist = $INF;
            $min_v = -1;
            for ($v = 0; $v < $nodeCount; $v++) {
                if (!$visited[$v] && $dist[$v] < $min_dist) {
                    $min_dist = $dist[$v];
                    $min_v = $v;
                }
            }

            // もしそのような頂点が見つからなければ終了
            if ($min_v == -1) break;

            // min_v を始点とした隣接するノードを探索する
            $nextSta = array_values($adjacentList[$min_v]);
            for ($i = 0; $i < count($nextSta); $i++) {
                // 緩和
                $this->chmin($dist[$nextSta[$i]], $dist[$min_v] + 1);
            }

            $visited[$min_v] = true; // 探索済みにする
        }
    }

    /**
     * ダイクストラ法
     *
     * @param array $adjacentList   隣接リスト (*参照渡し)
     * @param int   $nodeCount      ノードの総数
     * @param int   $startNode      始発ノードの番号
     * @param array $dist           距離 (*参照渡し)
     * @param array $prev           経路 (*参照渡し)
     * 
     * @return void
     */
    public function dijkstra_dist(&$adjacentList, $nodeCount, $startNode, &$dist, &$prev)
    {
        $INF = INF;

        $visited = array_fill(0, $nodeCount, false); // 訪問チェック
        $dist[$startNode] = 0; // 始点からの最短距離

        for ($iter = 0; $iter < $nodeCount; $iter++) {

            // 訪問済みでない頂点のうち dist 値が最小の頂点を探す
            $min_dist = $INF;
            $min_v = -1;
            for ($v = 0; $v < $nodeCount; $v++) {
                if (!$visited[$v] && $dist[$v] < $min_dist) {
                    $min_dist = $dist[$v];
                    $min_v = $v;
                }
            }

            // もしそのような頂点が見つからなければ終了
            if ($min_v == -1) break;

            // min_v を始点とした隣接するノードを探索する
            $nextStaNumber = array_keys($adjacentList[$min_v]);
            $nextStaDist = array_values($adjacentList[$min_v]);
            for ($i = 0; $i < count($nextStaNumber); $i++) {
                // 緩和
                if ($this->chmin($dist[$nextStaNumber[$i]], $dist[$min_v] + $nextStaDist[$i])) {
                    $prev[$nextStaNumber[$i]] = $min_v; // 前の駅情報を保存
                }
            }

            $visited[$min_v] = true; // 探索済みにする
        }
    }

    /**
     * 始発から目的地までのパスを取得する
     *
     * @param array $prev           1つ前のノード番号を持つ配列
     * @param int   $destination    目的地のノード番号
     * 
     * @return array 始発から目的地までの経路
     */
    public function getPath($prev, $destination)
    {
        $reversePath = array();

        // 目的地から遡ってパスを取得する
        for ($cur = $destination; $cur != -1; $cur = $prev[$cur]){
            array_push($reversePath, $cur); // 配列に追加
        }

        $path = array_reverse($reversePath); // リバースして始発順にする
        
        return $path;
    }
}
