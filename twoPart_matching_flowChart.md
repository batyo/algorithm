## フォードファルカーソン法を応用した二部マッチング
  
### 【シフト優先順位なし】  
| 探索順 | 従業員ノード | 出勤シフトノード |
|:-----:|:-----------:|:---------:|
| 1     | 1           | 6 ,7 ,8   |
| 2     | 2           | 8 , 9     |
| 3     | 3           | 6, 9      |
| 4     | 4           | 6, 9      |  

#### ~ 1週目 ~
#### findPath() メソッド 

**【 [隣接ノード] -- 探索中のノード 】**

	[1] -- 0
	[2] -- 0
	[3] -- 0
	[4] -- 0
	[6] -- 1
	[7] -- 1
	[8] -- 1
	[9] -- 2
	[10] -- 6

**【 始発ノードから終着ノードへのパス 】**

	0 -> 1 -> 6 -> 10

#### maxFlow() メソッド

	[0]<--[1]<--[6]<--[10]

	[0]-->[2],[3],[4]
	[1]-->[7],[8]
	[2]-->[8],[9]
	[3]-->[6],[9]
	[4]-->[6],[9]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]-->[10]
	[9]-->[10]
	[10]
  
#### ~ 2週目 ~
#### findPath() メソッド

	[2] -- 0
	[3] -- 0
	[4] -- 0
	[8] -- 2
	[9] -- 2
	[6] -- 3
	[10] -- 8

	0 -> 2 -> 8 -> 10

#### maxFlow() メソッド

	[0]<--[1]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]

	[0]-->[3],[4]
	[1]-->[7],[8]
	[2]-->[9]
	[3]-->[6],[9]
	[4]-->[6],[9]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]
	[9]-->[10]
	[10]
  
#### ~ 3週目 ~
#### findPath() メソッド

	[3] -- 0
	[4] -- 0
	[6] -- 3
	[9] -- 3
	[1] -- 6
	[10] -- 9

	0 -> 3 -> 9 -> 10

#### maxFlow() メソッド

	[0]<--[1]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]
	[0]<--[3]<--[9]<--[10]

	[0]-->[4]
	[1]-->[7],[8]
	[2]-->[9]
	[3]-->[6]
	[4]-->[6],[9]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]
	[9]
	[10]
  
#### ~ 4週目 ~
#### findPath() メソッド

	[4] -- 0
	[6] -- 4
	[9] -- 4
	[1] -- 6
	[3] -- 9
	[7] -- 1
	[8] -- 1
	[10] -- 7

	0 -> 4 -> 6 -> 1 -> 7 -> 10

#### maxFlow() メソッド

	[0]<--[1]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]
	[0]<--[3]<--[9]<--[10]
	[0]<--[4]<--[6]<--[1]<--[7]<--[10]

	[0]
	[1]-->[6],[8]
	[2]-->[9]
	[3]-->[6]
	[4]-->[9]
	[5]-->[10]
	[6]
	[7]
	[8]
	[9]
	[10]
  
#### ~ 5週目 ~
#### findPath() メソッド

	[0] からの増加パスなし
  
### 結果

従業員1 => シフト3 (ノード番号 7)  
従業員2 => シフト4 (ノード番号 8)  
従業員3 => シフト5 (ノード番号 9)  
従業員4 => シフト2 (ノード番号 6)

---

### 【シフト優先順位あり】  

| 従業員 \ シフト | 第1希望 | 第2希望 | 第3希望 |
|:------:|:-:|:-:|:-:|
| 従業員1 |	6 | 7 | 8 |
| 従業員2 | 8 | 9 |   |
| 従業員3 | 6 | 9 |   |
| 従業員4 | 9 | 6 |   |
  
* ノード探索順序
	1. シフトの選択肢が少ない従業員のノードから探索するようにする
	2. 優先順位の高いノードにノード番号が小さいシフトを持つ従業員から探索するようにする
  
| 探索順 | 従業員ノード | 出勤シフトノード |
|:------:|:-----------:|:---------:|
| 1      | 3           | 6, 9      |
| 2      | 2           | 8, 9      |
| 3      | 4           | 6, 9      |
| 4      | 1           | 6, 7, 8   |

⇒ 従業員3 -> 従業員2 -> 従業員4 -> 従業員1 の順に探索する
  
#### ~ 1週目 ~
#### findPath() メソッド
	
**【 [隣接ノード] -- 探索中のノード 】**

	[3] -- 0
	[2] -- 0
	[4] -- 0
	[1] -- 0
	[6] -- 3
	[9] -- 3
	[8] -- 2
	[7] -- 1
	[10] -- 6

**【 始発ノードから終着ノードへのパス 】**

	0 -> 3 -> 6 -> 10

#### maxFlow() メソッド

**【 逆方向への増加パス 】**

	[0]<--[3]<--[6]<--[10]

**【 順方向への増加パス 】**

	[0]-->[2],[4],[1]
	[1]-->[6],[7],[8]
	[2]-->[8],[9]
	[3]-->[9]
	[4]-->[9],[6]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]-->[10]
	[9]-->[10]
  
#### ~ 2週目 ~
#### findPath()　メソッド

	[2] -- 0
	[4] -- 0
	[1] -- 0
	[8] -- 2
	[9] -- 2
	[6] -- 4
	[7] -- 1
	[10] -- 8

	0 -> 2 -> 8 -> 10

#### maxFlow() メソッド

	[0]<--[3]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]

	[0]-->[1],[4]
	[1]-->[6],[7],[8]
	[2]-->[9]
	[3]-->[9]
	[4]-->[6],[9]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]
	[9]-->[10]
  
#### ~ 3週目 ~
#### findPath() メソッド

	[4] -- 0
	[1] -- 0
	[6] -- 4
	[9] -- 4
	[7] -- 1
	[8] -- 1
	[10] -- 9

	0 -> 4 -> 9 -> 10

#### maxFlow() メソッド

	[0]<--[3]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]
	[0]<--[4]<--[9]<--[10]

	[0]-->[1]
	[1]-->[6],[7],[8]
	[2]-->[9]
	[3]-->[9]
	[4]-->[6]
	[5]-->[10]
	[6]
	[7]-->[10]
	[8]
	[9]
  
#### ~ 4週目 ~
#### findPath() メソッド

	[1] -- 0
	[7] -- 1
	[10] -- 7

	0 -> 1 -> 7 -> 10

#### maxFlow() メソッド

	[0]<--[3]<--[6]<--[10]
	[0]<--[2]<--[8]<--[10]
	[0]<--[4]<--[9]<--[10]
	[0]<--[1]<--[7]<--[10]

	[0]
	[1]-->[6],[8]
	[2]-->[9]
	[3]-->[9]
	[4]-->[6]
	[5]-->[10]
	[6]
	[7]
	[8]
	[9]
  
### 結果

従業員1 => シフト3 第2希望 (ノード番号7)  
従業員2 => シフト4 第1希望 (ノード番号8)  
従業員3 => シフト2 第1希望 (ノード番号6)  
従業員4 => シフト5 第1希望 (ノード番号9)  