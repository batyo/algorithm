# algorithm

いくつかのアルゴリズムに関する関数を保存しています。<br/>
改善点等のご指摘があればどうぞ遠慮なくコメントを残していって下さい。

It stores functions related to several algorithms.<br/>
If you have any suggestions for improvement, please feel free to leave a comment.

## sample

アルゴリズムを用いたいくつかの例

### fordfulkerson_matrix
* フォードファルカーソン法の最大流問題
* グラフは配列形式で管理します
### moving_node_dfs
* 深さ優先探索
* 始発ノードから N ステップで到達できるノードを探します
* `$path` に探索開始から到達までに経由したノード番号が格納されます
### twoPart_matching
* フォードファルカーソン法を応用した二部マッチング問題
* 「従業員」と「シフト」を従業員の希望を考慮しながらマッチング数が最大になるようマッチングさせます
* シフトノードから終着ノードへの増加パスを変更することで「シフト」に割り当てることができる「従業員」の人数を操作できます
* 始発ノードから従業員ノードへの増加パスを変更することで「従業員」に割り振ることができる「シフト」の数を操作できます
* [twoPart_matching_flowChart.md](https://github.com/batyo/algorithm/blob/master/twoPart_matching_flowChart.md "フォールドファルカーソン法を応用した二部マッチング")
### interval_scheduling
* 貪欲法による区間スケジューリング
* 選択するイベント数を最大化するアルゴリズム
* 今後、日付型のデータからでも処理できるように改良する予定