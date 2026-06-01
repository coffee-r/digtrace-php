# Laravel12 Shop Migration Target

Laravel 12 + Oracle + Eloquent のローカルE2Eサンプルです。`experiments/ci3-shop` と同じ業務シナリオを Laravel 側で実装し、tekagami の `export` / `diff` で移行差分を確認することを目的にしています。

## 構成

- `laravel12-shop`: PHP 8.3、Laravel 12、Yajra OCI8、tekagami
- Oracle は `experiments/docker-compose.yml` の共有インスタンスを使う
- ログ出力: `experiments/laravel12-shop/var/tekagami.jsonl`

## 起動

通常は combined compose を使います。

```bash
cd experiments
docker compose up --build -d
docker compose exec laravel12-shop php artisan key:generate
bash laravel12-shop/scripts/run-e2e.sh
bash laravel12-shop/scripts/analyze.sh
bash laravel12-shop/scripts/diff.sh
```

生成物:

- `var/tekagami.jsonl`
- `var/flow-map.tsv`
- `var/export.json`
- `var/analysis.md`
- `var/diff.md`
- `var/diff.json`

`diff` は `experiments/ci3-shop/var/export.json` と Laravel 側の `var/export.json` を比較します。SQL 文字列が CI3 生 SQL と Eloquent 生成 SQL で違っても、layer-B fingerprint が一致する候補は `meaning_near_matches` に出ます。

## 注意

このアプリは Laravel の雛形ではなく、tekagami の移行調査デモです。代表出力は教材として残しており、再実行すると trace ID、時刻、flow ID などが変わります。
