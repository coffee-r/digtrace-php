# AGENTS.md

## このライブラリは何か

* 実行中のWebアプリの振る舞いを観測し、1リクエストを1行のJSON（JSONL）として記録するPHPライブラリ
* 目的は、**仕様調査・移行調査のための「証拠データ」を作る**こと
* 出すのは「観測された事実」であって「仕様」ではない。分析・要約・仕様の言語化は本ライブラリではやらず、生成AIや人に渡して任せる
* APMではない（速度・レイテンシは測らない）。見たいのは「何が起きたか」であって「速いか」ではない
* フレームワーク非依存・PHP 7.0以上・Composer配布。**どこに差し込むかは使う人が決める**。最初の実装対象はCodeIgniter3、次にLaravelを想定
* ログのJSONは**決まったスキーマ**で書く。こうすれば、別言語で同じスキーマを出すツールを作っても、同じやり方で掘り起こし・確認ができる

## 観測して記録すること

1つのhttp requestごとに、次の情報をJSON 1行にまとめて書き出す。

* スキーマのバージョン
* リクエストID（`trace_id`）
* 任意の調査フロー相関情報（`flow`。通常は null。開発者や QA が明示したヘッダ・テストコード由来の ID など。生のセッションIDは使わない）
* 採取時刻（アプリ識別子・環境は JSONL ではなくファイル名や保存パスで管理する）
* **HTTP入力**: URL、メソッド、ヘッダ、query parameter、request body
* **HTTP出力**: ステータス、種別（json / html / その他）、json本体、viewに渡す配列、ヘッダ
  * htmlは本文がでかくなるので解析せず、テンプレート名と「渡した変数の形」だけ記録する方針
* **時系列のデータ操作**（起きた順に並べる）
  * 発行されたSQL
  * 任意の操作（使う人が自前でロギングコードを埋め込む）

値はできる限り生のままでなく「**形（shape）**＝構造とスカラー型」で残す。インデックス配列は要素 shape を重複排除して表現する。

## 値の記録のしかた（マスキング）

実データ（SQLやリクエスト値）には個人情報・認証情報・決済情報が混ざりうるので、**デフォルトでは実値を一切出さない**（shape のみ）。実値の保持は **白リストで明示オプトインしたものだけ**。値ごとに次の表現を使い分ける。

| 種類 | フィールド | 概要 |
|---|---|---|
| **伏せ字（shape）** | `*_shape`, `statement_normalized` | 構造とスカラー型のみ／具体値を `{parameter}` に置換。常に保存。実値なし。集計・パターン分類の土台 |
| **目印つき伏せ字** | `*_tokens` | `HMAC-SHA256(値, secret)` の先頭 N 桁（`tokenHmacLength` で変更可、デフォルト12）。同一値 → 同一記号。復元不可。共有シークレット（`secret`）設定時のみ |
| **あえて残す実値** | `query_values` / `request_values`（HTTP）、`observed_values`（SQL） | 機密でない業務判断材料（金額・区分コード等）を実値のまま保持。`keepKeys` / `sqlValueAllowlist` で列挙したものだけ |
| **生 SQL 平文** | `statement_text` | 生 SQL 文字列そのもの。デフォルト off（`captureText=true` で有効化・**平文**・開発用） |

実値を残す対象は、白リストで指定する（実値のオプトイン）。

* `keepKeys` … HTTP の query/request の**キー名**で指定（完全一致・大小無視）→ `*_values`
* `keepHeaderKeys` … HTTP リクエストヘッダ名で指定（完全一致・大小無視）→ `request_headers_shape` / `request_headers_tokens`。空ならリクエストヘッダの存在情報も記録しない
* `keepResponseHeaderKeys` … HTTP レスポンスヘッダ名で指定（完全一致・大小無視）→ `response_headers_shape` / `response_headers_tokens`。空ならレスポンスヘッダの存在情報も記録しない
* `sqlValueAllowlist` … SQL の **`テーブル名.列名`（または列名だけ）** で指定（大小無視）→ `observed_values`

> **黒リスト（`denyKeys`）は持たない。** 実値は明示オプトインのみなので「黒が白に勝つ」順序ルールは存在しない。
> 注意: `keepKeys` / `sqlValueAllowlist` に `password` / `token` 等の機密キーを入れると**そのまま実値が残る**。何を白リストに載せるかは利用者の責任。機密値を相関のためだけに見たいなら `secret`（不可逆 HMAC トークン）を使う。

## やらないこと・できないこと

* 観測データの分析機能は作らない（生成AIや人に渡して分析してもらう想定）
* アプリの速度は測らない
* 仕様の断定はできない。実データに基づくので、**観測できなかったケースは掘り起こせない**
* PHPのメソッド呼び出し順は追わない（`debug_backtrace` でできるし、本ツールの役目ではない）
* 完全なSQL構文解析、完全なcall graph、HTML UIや図の自動生成 はしない

## スキーマと検証

* JSONの構造は **JSON Schema** で明示し、コードを読まなくても分かる場所（`docs/schema`）に置く
* スキーマは**言語に依存しない契約**として扱う（他言語で同じスキーマを出せば同じツールで掘れる、が核）
* 検証は **テスト/CI上の契約チェック**として行い、本番の毎リクエストではやらない（観測負荷を上げない）
* fixtureと実際に生成したログの両方をスキーマ検証する。AI送付用 `export` ではSQL全文の重複を辞書化し、層Bフィンガープリントを残す
* 現在の `tekagami-v1` では SQL イベントの `statement_fingerprint` は必須。旧JSONL（このフィールドがないもの）は新スキーマの対象外

## SQL解析の信頼度

* 完全な構文解析はしない。正規表現ベースの best-effort（ほどほどに頑張る）
* 伏せ字SQL（`statement_normalized`）とそのハッシュ（`statement_hash`）は、同じSQLパターンをまとめる層Aとして使う。値位置の `NULL` は `{parameter}`、DB生成時刻（`SYSTIMESTAMP` / `CURRENT_TIMESTAMP` / `CURRENT_DATE` / `SYSDATE` / `NOW()`）は `{db_time}` に正規化する
* 層B（`statement_fingerprint`）は、操作種別・対象テーブル・絞り込み列・書込列から作る意味レベルの署名。CI3生SQLとLaravel/EloquentのSQL文字列差をまたぐ移行調査の主材料にする
* 操作種別（SELECT/INSERT/…）は先頭付近から推定し、判定できなければ `UNKNOWN`
* 対象テーブルは best-effort（サブクエリ・方言・動的SQLで漏れ・誤りが出うる）
* 各SQLに信頼度メタ（`analysis`: analyzer / 操作の確度 / テーブルの確度 / 警告）を付ける

## 採取対象と本番負荷

* 低頻度の分岐やエッジケースを落とさないため、ライブラリ本体に採取率の設定は持たせない
* 採取対象を絞る場合は、フレームワーク側の差し込み箇所・環境設定・ログ期間で制御する
* 引数の自動キャプチャ・DBスナップショットはしない
* **ログ書き込みに失敗してもアプリ本体は止めない／挙動も変えない**

## 組み込み方針

* 組み込みは**薄く・中央集約で**。フレームワークのフックやミドルウェアでトレース開始・終了を扱い、業務ロジックには手を入れない
* **差し込み箇所は使う人が決める**（フレームワーク非依存）
* ライブラリ本体（core）が持つもの: スキーマ定義、JSON Schema、収集、正規化、マスキング、出力先（sink）、JSONL書き出し、集計レポート（`bin/tekagami report`）、AI送付用コンパクト出力（`bin/tekagami export`）
* CI3 / Laravel は同梱アダプタではなく `examples/` の組み込み例として扱う

## Export / Report

* レポートは「観測された入口」（メソッド + URLパターン）と「実行パターン」でトレースをまとめる
* 実行パターンは、SQLの（操作 + テーブル + ハッシュ）の並び ＋ custom イベント ＋ ステータス から機械的に分類する
* **AIを通さず決定論的に作れる**レポートを基本にする。要約・命名・業務ルール推論・日本語仕様化は本体の外
* AI送付用には `bin/tekagami export` を使う。SQL全文は `sql_dictionary` に一度だけ出し、各パターンの `sql_flow` は `S1` のような短IDと層B `fp` を参照する
* legacy / target をそれぞれ `export` し、`bin/tekagami diff` で決定論的な差分を出す。必要なコード・DDL・fixture と一緒に AI や人間が読む流れにする
* 複数サーバのログは `cat` で JSONL を連結するか、`report` / `export` コマンドに複数ファイルを渡す

## 観測の限界（明示する）

* 出すのは「観測された事実」。**観測されなかった ＝ 存在しない、ではない**
* カバレッジは観測期間・流したシナリオ・環境差・採取対象の絞り込みで変わる。低頻度・月次・特定ユーザ・エラー時だけの分岐は漏れうる
* しきい値や業務ルールは、根拠が足りなければ「仕様候補」として扱う
* レポートには観測件数・初回/最終観測時刻など、カバレッジを判断できる材料を含める。アプリ名・環境は入力ファイル名や保存場所で表す

---

## 実装メモ（v1 実装の設計判断）

### エラーと可観測性

エラーの記録方法を2種に分ける:

| 状況 | 記録先 |
|---|---|
| キャプチャ中のあらゆるエラー（SQL 解析失敗・shape 生成失敗・timeline 打ち切りなど） | JSONL の `errors[]` フィールド |
| `sink->write()` の失敗（JSONL 自体が書き出せない） | PHP の `error_log()`（Apache ログ） |

`errors[]` が空 = クリーンキャプチャ。非空 = 観測時に何らかの問題あり、というシグナルになる。
Apache ログは「ログが書けなかった」という運用上の障害のみに絞る。

これは CollectorInterface のコメント原案から変更している（元の案は `capture_failure` を常に `error_log()` に出力する設計だった）。

### メモリ対策

リクエストごとのメモリ使用を制限する設定を Config に追加:

* `maxDepth = 10`: shape 生成の再帰深さ上限。超えると `'...'` を返して打ち切り
* `maxShapeNodes = 10000`: shape 生成の総ノード訪問数上限。深さだけでなく横への広がりも制限する。大量キーの連想配列や数万件のレスポンスに対応
* `maxTimelineSize = 500`: timeline イベント数の上限（デフォルト 500・null = 無制限）。本番で SQL 発行数が膨大な場合のセーフティ

各上限に達した場合、tekagami の観測だけを打ち切り、アプリ本体の処理は止めない。打ち切りは JSONL の `errors[]` に `capture_failure` として残す。

インデックス配列の shape は重複排除される（`[1,2,3]` → `["number"]`）ため、大量要素の配列は自動的に圧縮される。

### HttpInput の設計方針

`HttpInput` は値オブジェクト。コンストラクタで `method` と `path` を受け取り、残りはパブリックプロパティへの代入で渡す。

```php
$http = new HttpInput('POST', '/orders');
$http->queryRaw          = /* フレームワークが解析済みのクエリ */;
$http->requestRaw        = /* フレームワークが解析済みのボディ */;
$http->requestHeadersRaw = /* ヘッダ配列 */;
$http->pathPattern       = /* ルートパターン文字列 */;
```

`HttpResponse` も値オブジェクト。`status` / `responseKind` / `contentType` / `responseBodyRaw` / `views` に加えて、フレームワークが取得済みのレスポンスヘッダを `responseHeadersRaw` に渡せる。実際に記録されるのは `keepResponseHeaderKeys` に一致したヘッダの shape と HMAC token のみで、平文のレスポンスヘッダ値は保存しない。

**`fromGlobals()` は作らない**: `php://input` はストリームなので一度読むと消える。フレームワークが先に読んでいると空になるリスクがある。そのため「フレームワークが既にパースした値を渡す」設計にして、グローバルへの依存をライブラリ本体に持ち込まない。

フレームワーク別の推奨取得元:

| フレームワーク | queryRaw | requestRaw |
|---|---|---|
| CI3 | `$this->input->get()` | `json_decode($this->input->raw_input_stream, true)` または `$this->input->post()` |
| Laravel | `$request->query()` | `$request->all()` |
| 素の PHP | `$_GET` | `json_decode(file_get_contents('php://input'), true)` ※先読みに注意 |

**pathPattern について**: CI3 は公式 API でパターン文字列（`/products/{id}` 形式）を取り出せない。CI3 アダプタ実装時は `config/routes.php` にヘルパーを追加してもらう、または現 URI にマッチしたルート定義を逆引きして変換する実装を検討する。不明な場合は `null` のままにする（Aggregator は実 path でグルーピングにフォールバックする）。

### SQL 解析の best-effort 仕様

* 統合 regex（シングルクォート優先の alternation）で正規化。二重置換を防ぐため単一パスで処理
* SQL 採取 API は高信頼の `addSql($sql, $binds, ['source' => '...'])` と、低信頼の `addExpandedSql($sql, ['source' => '...'])` に分ける。前者は bind 前 SQL + binds、後者は `last_query()` / query history など bind 展開済み SQL 用
* `analysis.input_quality` は API 側で固定する。`addSql` は `bound_sql`、`addExpandedSql` は `expanded_sql`
* `addExpandedSql` では `expanded_sql_may_fragment_statement_hash` warning を出す。source が `query_history` / `last_query` 系なら bind 分離不能 warning も出す
* ダブルクォートは識別子（テーブル名・列名）として扱い、リテラルとして正規化しない
* スキーマ付きテーブル名（`SHOP.ORDERS`）はフルで保持
* `CALL` / `EXECUTE` / `EXEC` はすべて operation `'CALL'` に正規化
* statement_tokens（HMAC トークン化 SQL）は元の SQL に対して同一 regex を `preg_replace_callback` で適用し生成する（normalized とは別パス）

### SQL 意味フィンガープリント（層B）

* `SqlFingerprinter` は `SqlAnalyzerInterface` には足さず、`Sql/` 配下の best-effort 内部クラスとして独立させる
* `Collector::addSql()` はすべての SQL イベントに `statement_fingerprint` を必ず入れる。計算失敗時もアプリには例外を伝播させず、空列集合の最低限の fingerprint を入れる
* `SqlValueExtractor::extractColumns()` は allowlist・値の有無に関係なく、INSERT列リスト、SET左辺、WHERE/ON/HAVING比較左辺から列名だけを拾う。既存の実値抽出 `extract()` は変更しない
* 列集合は大文字化・テーブル修飾除去・ソート・重複排除。`fp_hash` 計算時のテーブル名は `SCHEMA.ORDERS` の末尾 `ORDERS` を使い、`fp1:` プレフィクス付き sha256 にする

### CLI（bin/tekagami）

```
php bin/tekagami report <jsonl...> [--format md|json] [--value-mode normalized|tokenized]
php bin/tekagami export <jsonl...> [--format json|md] [--value-mode normalized|tokenized]
php bin/tekagami diff   <legacy-export.json> <target-export.json> [--format json|md]
```

* 複数 JSONL ファイルを受け付けてマージ処理（ロードバランス環境での複数サーバログ集計に対応）
* 全出力は STDOUT（ファイル保存はシェルのリダイレクトで）
* plain PHP 実装（Symfony Console 等への依存なし）、`vendor/bin` 経由でも動作

**`diff` の入出力仕様:**

- 入力: 2つの `export.json`（`bin/tekagami export` が生成したもの）
- 出力: 決定論的な差分（全配列がソート済み。AI 要約なし）
- 検出する差分:
  - `entrypoints.added` / `removed` — エントリポイントの追加/消失
  - `entrypoints.changed[].status_codes` — status_codes カウントの増減
  - `entrypoints.changed[].patterns` — パターン追加/消失/変化（statuses, effects, custom_events）
  - `meaning_near_matches` — 同一 layer-B fp で SQL 文字列が異なる候補（意味近似一致候補）
- パターンマッチングは layer-B fp の系列 + STATUS で行う（S-ID は使わない）
- デフォルト format は `json`

### Diff 機能（DiffEngine / DiffMarkdownRenderer）

`src/Report/DiffEngine.php`:
- `diff(array $legacy, array $target): array` — 公開 API のみ
- `buildSemanticKey()` — SQL の fp 系列 + STATUS でパターンを識別（CUSTOM イベントはキーに含めない）
- `parseCustomEvents()` — シグネチャ文字列から `CUSTOM:label` を抽出
- `buildFpToSqlMap()` — fp → SQL テキスト map を構築（meaning_near_match 検出用）
- `findMeaningNearMatches()` — 両エクスポートで同一 fp だが SQL テキストが異なる候補を返す

`src/Report/DiffMarkdownRenderer.php`:
- `render(array $diff): string` — 変化のないセクションを省略した Markdown を生成

### パターンシグネチャ算出（Aggregator）

実行パターンの同定に使う文字列キー。人間可読形式を採用:

```
SELECT:PRODUCTS:sha256:abc -> INSERT:ORDERS:sha256:def -> STATUS:201
```

* `timeline` を seq 順に走査し、`type=sql` → `{op}:{tables}:{hash}`、`type=custom` → `CUSTOM:{label}` を連結
* 末尾に `STATUS:{status}` を追加して `->` でつなぐ
* 同じ文字列のトレースを同一パターンとして集計（ハッシュは使わず文字列をそのまま ID として使用）
* `Aggregator::buildSqlFlow()` は `statement_fingerprint` を持ち上げ、`CompactExporter` が再走査なしで層Bを参照できるようにする

### Compact Export

* `bin/tekagami export` は `JsonlReader -> Aggregator -> CompactExporter` の順で、1データセットから1つのコンパクト成果物を作る
* JSON出力はデフォルトで pretty 印字しない（`JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES`）
* `sql_dictionary` に一意SQLを `S1`, `S2`, ... として集約し、各 pattern の `sql_flow` は `s`, `op`, `tables`, `fp` の最小形にする
* `observed_flow_signature` は出さず、`compressed_flow_signature` を短ID版 `signature` に変換して出す

### スキーマ検証（契約チェック）

`tests/SchemaConformanceTest.php` が `docs/schema/tekagami-v1.schema.json`（JSON Schema draft 2020-12）に対して
fixture と実 `Collector` 出力の両方を検証する。本番の毎リクエストでは行わない（観測負荷を上げない）。
バリデータは `opis/json-schema`（`require-dev`）。

### サンプルアプリケーション（examples/）

**`examples/ci3-shop`**: CodeIgniter 3 + Oracle の EC 系デモアプリ。7エンドポイント・36シナリオの E2E で観測ログを生成する。

**`examples/laravel12-shop`**: 同じ業務シナリオを Laravel 12 + Oracle + Eloquent で実装したアプリ。CI3 shop との export を `diff` コマンドで比較することが目的。

**`examples/docker-compose.yml`**: 共有 Oracle インスタンス上で ci3-shop と laravel12-shop を同時に起動する combined compose。

Docker アーキテクチャ（combined compose）:
- Oracle: 1インスタンス、`digshop` (CI3用) + `lshop` (Laravel用) の2スキーマ
- ci3-shop: PHP 7.3 + Apache、port 8088
- laravel12-shop: PHP 8.3 + artisan serve、port 8089
- `lshop` ユーザーは `examples/laravel12-shop/docker/oracle/init/10-lshop-user.sh` で SYSDBA 接続して作成

起動手順:
```bash
cd examples
docker-compose up --build -d
docker-compose exec laravel12-shop php artisan key:generate
# E2E 実行後に diff を生成
bash laravel12-shop/scripts/run-e2e.sh
bash laravel12-shop/scripts/analyze.sh
bash laravel12-shop/scripts/diff.sh
```

**SQL 差分と meaning_near_matches:**
- CI3 生 SQL: `SELECT * FROM shop_products WHERE code = :p1`
- Laravel/Eloquent/yajra: `select * from "SHOP_PRODUCTS" where "CODE" = ?`
- `extractTables()` は `strtoupper` + quote strip で正規化するため layer-B fp は一致する
- 上記の SQL テキスト差が `meaning_near_matches` に現れることが diff のデモ意図

### 実装されていないもの（v1 のスコープ外）

* `timeline` の `type: "external_http"`（外部 WebAPI 呼び出し）・`type: "file"`・`type: "session"`。必要な場合は `addCustom()` で手動記録する
* `observed_values` のトークン化版（`redacted: true`）。現状は `sqlValueAllowlist` にマッチした列の実値（`redacted: false`）のみ抽出する
