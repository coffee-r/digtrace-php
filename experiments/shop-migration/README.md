# shop-migration

Oracle shop アプリケーションの **CI3 → Laravel 12 移行** を示すシナリオです。

- `ci3-shop/`: legacy — CodeIgniter 3 + Oracle
- `laravel12-shop/`: target — Laravel 12 + Oracle (Eloquent + yajra/laravel-oci8)
- `diff/`: 移行比較出力（`diff.md`, `diff.json`）
- `spec-workflow/`: `spec/prompts/` をこのシナリオに適用した例

同じ 7 エンドポイント・同一 custom event ラベルを実装しており、`diff` コマンドで SQL フィンガープリント（層 B）の意味近似一致を確認できます。

## 実行

```bash
cd experiments/shop-migration
docker compose up --build -d
docker compose exec laravel12-shop php artisan key:generate

# 観測 & 証拠生成
bash ci3-shop/scripts/run-e2e.sh
bash ci3-shop/scripts/report.sh
bash ci3-shop/scripts/analyze.sh
bash laravel12-shop/scripts/run-e2e.sh
bash laravel12-shop/scripts/analyze.sh
bash laravel12-shop/scripts/diff.sh
```

## 生成物

| ファイル | 内容 |
|---------|------|
| `ci3-shop/var/tekagami.jsonl` | CI3 観測ログ（raw） |
| `ci3-shop/var/summary.md` | CI3 endpoint 地図 |
| `ci3-shop/var/report.md` | CI3 挙動パターン集計 |
| `ci3-shop/var/export.json` | CI3 AI 投入用コンパクト版 |
| `laravel12-shop/var/tekagami.jsonl` | Laravel 観測ログ（raw） |
| `laravel12-shop/var/export.json` | Laravel AI 投入用コンパクト版 |
| `diff/diff.md` | 移行差分（意味近似 SQL 一致を含む） |
| `diff/diff.json` | 移行差分（JSON） |

生成物の再実行はトレース ID・タイムスタンプが変わるため、コミット済みサンプルと diff が出ます。コミット済みサンプルを参照する場合はそのまま使えます。

生成物を使って仕様候補を作る場合は `spec-workflow/` と `spec/prompts/` を参照してください。
