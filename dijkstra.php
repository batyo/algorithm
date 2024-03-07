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
     * @param int|float $INF        無限 (デフォルト値 PHP_INT_MAX)
     * 
     * @return void
     */
    public function dijkstra(&$adjacentList, $nodeCount, $startNode, &$dist, $INF = INF)
    {
        $used = array_fill(0, $nodeCount, false);
        $dist[$startNode] = 0;
        for ($iter = 0; $iter < $nodeCount; $iter++) {
            // 使用済みでない頂点のうち dist 値が最小の頂点を探す
            $min_dist = $INF;
            $min_v = -1;
            for ($v = 0; $v < $nodeCount; $v++) {
                if (!$used[$v] && $dist[$v] < $min_dist) {
                    $min_dist = $dist[$v];
                    $min_v = $v;
                }
            }
            // もしそのような頂点が見つからなければ終了
            if ($min_v == -1) break;

            // min_v を始点とした各辺を探索する
            $nextSta = array_values($adjacentList[$min_v]);
            for ($i = 0; $i < count($nextSta); $i++) {
                // 緩和
                $this->chmin($dist[$nextSta[$i]], $dist[$min_v] + 1);
            }
            $used[$min_v] = true; // 探索済みにする
        }
    }
}
