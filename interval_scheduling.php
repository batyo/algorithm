<?php

/**
 * 貪欲法による区間スケジューリング問題
 */
class IntervalScheduling
{
    /**
     * スケジュールイベントを選択する
     *
     * @param array $schedul イベントの区間情報
     * [ ["start" => 1, "end" => 5], ["start" => 4, "end" => 8], ... ]
     * 
     * @return int 選択したイベントの数
     */
    public function selectSchedul($schedul)
    {
        // 終了時刻が早い順に並び替え
        usort($schedul, array($this, "compare_asc"));

        $selectedCount = 0; // 選択したイベントの数
        $currentEndTime = 0; // 現在の終了時刻

        for ($i = 0; $i < count($schedul); $i++) {
            if ($schedul[$i]["start_time"] < $currentEndTime) continue;

            $selectedCount++;
            $currentEndTime = $schedul[$i]["end_time"];
        }

        return $selectedCount;
    }

    /**
     * 2つの値を比較する usort() のコールバック関数
     * 
     * 昇順に並び替えるよう return する
     *
     * @param array $first  1つ目の値
     * @param array $second 2つ目の値
     * 
     * @return int
     */
    private function compare_asc($first, $second)
    {
        // 並び替えなし
        if ($first["end_time"] == $second["end_time"]) return 0;

        $compare = $first["end_time"] < $second["end_time"];

        // 昇順に並び替える
        if ($compare) return -1; // $second のインデックス値より 1 小さい
        if ( !$compare ) return 1; // $second のインデックス値より 1 大きい
    }
}
