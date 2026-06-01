# shop-migration spec workflow

このディレクトリは、`shop-migration` シナリオの観測証拠を使って `spec/prompts/` の流れを試した置き場です。

大きい JSONL / export をここへ複製せず、`ci3-shop/var/` を直接参照します。

## 代表入力

- `../ci3-shop/var/tekagami.jsonl`
- `../ci3-shop/var/summary.json`
- `../ci3-shop/var/summary.md`
- `../ci3-shop/var/export.json`
- `../ci3-shop/app/application/config/routes.php`
- `../ci3-shop/app/application/controllers/api/Shop.php`
- `../ci3-shop/app/application/models/Shop_model.php`
- `../ci3-shop/docker/oracle/init/01-schema.sql`
- `../diff/diff.json` — CI3 vs Laravel 移行差分

## プロンプト

- `SUMMARY_PROMPT.md`: summary の endpoint 地図から深掘り優先度を決める
- `ENTRYPOINT_PROMPT.md`: filter 済み export で 1 endpoint / endpoint group を分析する
- `SYNTHESIS_PROMPT.md`: endpoint 別分析結果を統合する
- `DIFF_PROMPT.md`: legacy vs target の移行差分を分析する
- `PROMPT.md`: 小規模 example を一括で読む旧来の業務発見プロンプト（参考）

## deep dive 例

```bash
php ../../../../tools/tekagami-data/bin/tekagami summary ../ci3-shop/var/tekagami.jsonl \
  --format json > inputs/summary.json

php ../../../../tools/tekagami-data/bin/tekagami export ../ci3-shop/var/tekagami.jsonl \
  --path "/api/cart/*" > inputs/cart.export.json
```

その後、`spec/prompts/01_summary_triage.md` から順に使います。
