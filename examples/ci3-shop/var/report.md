# 観測振る舞い証拠レポート

- 生成日時: `2026-06-01T16:40:31+00:00`
- トレース数: `69`
- 観測エントリポイント数: `7`
- 観測期間: `2026-06-01T16:40:09+00:00` ～ `2026-06-01T16:40:11+00:00`
- 値モード: `normalized`

> 観測エントリポイントは証拠ビューであり、移行単位の仮定ではありません。

## POST /api/cart/items

- エントリポイントキー: `POST /api/cart/items`
- 観測リクエスト数: `36`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 201 | 32 |
| 404 | 1 |
| 422 | 3 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-1 | 21 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |
| pattern-10 | 5 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |
| pattern-4 | 2 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → UPDATE SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |
| pattern-2 | 1 | 404 | SELECT SHOP_PRODUCTS |
| pattern-3 | 1 | 422 | SELECT SHOP_PRODUCTS |
| pattern-5 | 1 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → UPDATE SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |
| pattern-6 | 1 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS → INSERT SHOP_CART_ITEMS |
| pattern-7 | 1 | 422 | SELECT SHOP_PRODUCTS |
| pattern-8 | 1 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_CUSTOMERS → SELECT SHOP_PRODUCTS → INSERT SHOP_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |
| pattern-9 | 1 | 422 | SELECT SHOP_PRODUCTS → SELECT SHOP_CUSTOMERS |
| pattern-11 | 1 | 201 | SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → INSERT SHOP_RESERVATION_CART_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS |

### 振る舞いパターン: pattern-1

- 観測数: `21`
- 代表トレース: `f49087ea-ef0e-4d4b-bb4f-42bb732a4c5b`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 21 |

### 振る舞いパターン: pattern-10

- 観測数: `5`
- 代表トレース: `0f996793-decf-4152-b917-74f7e24284f7`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 5 |

### 振る舞いパターン: pattern-4

- 観測数: `2`
- 代表トレース: `acf857e8-b261-406a-9fc9-91ad4325b5e5`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> UPDATE:SHOP_CART_ITEMS:sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70 -> CUSTOM:yumail_product_code_swapped -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x3 -> UPDATE:SHOP_CART_ITEMS:sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70 -> CUSTOM:yumail_product_code_swapped -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
8. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
9. `UPDATE` on `SHOP_CART_ITEMS`
   ```sql
   UPDATE shop_cart_items SET product_code = {parameter}, unit_price = {parameter} WHERE cart_id = {parameter} AND product_code = {parameter}
   ```
   ハッシュ: `sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70`
10. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 2 |
| UPDATE | SHOP_CART_ITEMS | 2 |

### 振る舞いパターン: pattern-2

- 観測数: `1`
- 代表トレース: `2cf4841f-63c5-4559-a3fe-0c93d5d639ae`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> STATUS:404`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> STATUS:404`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-3

- 観測数: `1`
- 代表トレース: `a97b1901-2ce8-4e5a-b98c-438473d4925f`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-5

- 観測数: `1`
- 代表トレース: `cfa3bc9b-ecc1-4df8-b3f7-73dac67e5f2c`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> UPDATE:SHOP_CART_ITEMS:sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70 -> CUSTOM:yumail_product_code_reverted -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> UPDATE:SHOP_CART_ITEMS:sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70 -> CUSTOM:yumail_product_code_reverted -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
8. `UPDATE` on `SHOP_CART_ITEMS`
   ```sql
   UPDATE shop_cart_items SET product_code = {parameter}, unit_price = {parameter} WHERE cart_id = {parameter} AND product_code = {parameter}
   ```
   ハッシュ: `sha256:b4bcc895c34428fde62cc6732064fd1ac8aa601da544cb87333bb9b6efe8ed70`
9. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 1 |
| UPDATE | SHOP_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-6

- 観測数: `1`
- 代表トレース: `f6bef833-6101-41c5-b2aa-4e19d2c388b0`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> SELECT:SHOP_CART_ITEMS:sha256:69645bda0387f601ff8dd8aceb965a4f5116ae4ed7927e74dd572e20de83693a -> INSERT:SHOP_CART_ITEMS:sha256:962b4a09eb4ab2f059de5c1ca17fdfd3f76ae497e6a8c5ae1d8d2fd670bca66a -> CUSTOM:gift_attached -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> SELECT:SHOP_CART_ITEMS:sha256:69645bda0387f601ff8dd8aceb965a4f5116ae4ed7927e74dd572e20de83693a -> INSERT:SHOP_CART_ITEMS:sha256:962b4a09eb4ab2f059de5c1ca17fdfd3f76ae497e6a8c5ae1d8d2fd670bca66a -> CUSTOM:gift_attached -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`
8. `SELECT` on `SHOP_CART_ITEMS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items WHERE cart_id = {parameter} AND product_code = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:69645bda0387f601ff8dd8aceb965a4f5116ae4ed7927e74dd572e20de83693a`
9. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             SELECT {parameter}, MIN(customer_id), {parameter}, {parameter}, {parameter}, {parameter}, {db_time} FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:962b4a09eb4ab2f059de5c1ca17fdfd3f76ae497e6a8c5ae1d8d2fd670bca66a`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 1 |
| INSERT | SHOP_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-7

- 観測数: `1`
- 代表トレース: `bdba9720-f407-4d47-a726-b54d37455c06`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:point_exchange_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:point_exchange_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-8

- 観測数: `1`
- 代表トレース: `958a3040-6925-4939-adda-4eb0d05a898b`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_checked -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_checked -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_CART_ITEMS:sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
3. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
4. `INSERT` on `SHOP_CART_ITEMS`
   ```sql
   INSERT INTO shop_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:8e5bbcf5bd29e9249196f3ca211ceee12f2b9d2b9fcbfea0f6767ad5c89125a5`
5. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
6. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
7. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
8. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-9

- 観測数: `1`
- 代表トレース: `f8d24b52-ee8d-48d2-ad85-9955d8c02763`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-11

- 観測数: `1`
- 代表トレース: `820fc3eb-acad-47e8-b6d2-a23f548c24ed`
- シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> INSERT:SHOP_RESERVATION_CART_ITEMS:sha256:fbd6f4495a3111243434ab87efdaa622e224f299ca921afdc5f5440980f19ff2 -> CUSTOM:reservation_cart_used -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> INSERT:SHOP_RESERVATION_CART_ITEMS:sha256:fbd6f4495a3111243434ab87efdaa622e224f299ca921afdc5f5440980f19ff2 -> CUSTOM:reservation_cart_used -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3 -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
2. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
3. `INSERT` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   INSERT INTO shop_reservation_cart_items (cart_id, customer_id, product_code, quantity, unit_price, is_gift, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:fbd6f4495a3111243434ab87efdaa622e224f299ca921afdc5f5440980f19ff2`
4. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
5. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT {parameter} AS found FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code WHERE ci.cart_id = {parameter} AND p.gift_trigger = {parameter} AND ROWNUM = {parameter}
   ```
   ハッシュ: `sha256:2382410535cf64726d11659c1ee937674b8bb516540b042c407aced3f89b5ba3`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_RESERVATION_CART_ITEMS | 1 |

## POST /api/checkout/quote

- エントリポイントキー: `POST /api/checkout/quote`
- 観測リクエスト数: `14`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 200 | 5 |
| 422 | 9 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-3 | 4 | 200 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS |
| pattern-2 | 3 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS |
| pattern-1 | 1 | 200 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES → SELECT SHOP_REMOTE_ISLAND_POSTALS → SELECT SHOP_WORKING_DAYS |
| pattern-4 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS |
| pattern-5 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES |
| pattern-6 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES → SELECT SHOP_REMOTE_ISLAND_POSTALS |
| pattern-7 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES → SELECT SHOP_REMOTE_ISLAND_POSTALS → SELECT SHOP_WORKING_DAYS → SELECT SHOP_WORKING_DAYS |
| pattern-8 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES → SELECT SHOP_REMOTE_ISLAND_POSTALS → SELECT SHOP_WORKING_DAYS |
| pattern-9 | 1 | 422 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS |

### 振る舞いパターン: pattern-3

- 観測数: `4`
- 代表トレース: `3881fe16-9651-4a79-97c3-3a3f4542748d`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> STATUS:200`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> STATUS:200`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-2

- 観測数: `3`
- 代表トレース: `560c997e-901e-4b68-ab64-8b2f94b02cc0`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-1

- 観測数: `1`
- 代表トレース: `5b2d018b-b46b-4aae-afa9-6a2524504c26`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:free_shipping_applied -> STATUS:200`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:free_shipping_applied -> STATUS:200`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
5. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`
6. `SELECT` on `SHOP_REMOTE_ISLAND_POSTALS`
   ```sql
   SELECT {parameter} AS found FROM shop_remote_island_postals WHERE postal_code = {parameter}
   ```
   ハッシュ: `sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb`
7. `SELECT` on `SHOP_WORKING_DAYS`
   ```sql
   SELECT work_date, is_working FROM shop_working_days WHERE work_date BETWEEN TO_DATE({parameter}, {parameter}) AND TO_DATE({parameter}, {parameter}) ORDER BY work_date
   ```
   ハッシュ: `sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-4

- 観測数: `1`
- 代表トレース: `e74d272b-0d30-4462-a4b5-21e6886cdb97`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:delivery_date_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:delivery_date_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-5

- 観測数: `1`
- 代表トレース: `58ac273e-959f-4d8f-a4f5-1bf9a0b393c1`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> CUSTOM:delivery_date_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> CUSTOM:delivery_date_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
5. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-6

- 観測数: `1`
- 代表トレース: `0ac9f08d-190b-41f6-b444-a68619c6bd11`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> CUSTOM:delivery_date_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> CUSTOM:delivery_date_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
5. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`
6. `SELECT` on `SHOP_REMOTE_ISLAND_POSTALS`
   ```sql
   SELECT {parameter} AS found FROM shop_remote_island_postals WHERE postal_code = {parameter}
   ```
   ハッシュ: `sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-7

- 観測数: `1`
- 代表トレース: `a288a151-eb60-4b06-8b6d-6c6cbf4905c7`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:delivery_date_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 x2 -> CUSTOM:delivery_date_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
5. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`
6. `SELECT` on `SHOP_REMOTE_ISLAND_POSTALS`
   ```sql
   SELECT {parameter} AS found FROM shop_remote_island_postals WHERE postal_code = {parameter}
   ```
   ハッシュ: `sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb`
7. `SELECT` on `SHOP_WORKING_DAYS`
   ```sql
   SELECT work_date, is_working FROM shop_working_days WHERE work_date BETWEEN TO_DATE({parameter}, {parameter}) AND TO_DATE({parameter}, {parameter}) ORDER BY work_date
   ```
   ハッシュ: `sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308`
8. `SELECT` on `SHOP_WORKING_DAYS`
   ```sql
   SELECT work_date, is_working FROM shop_working_days WHERE work_date BETWEEN TO_DATE({parameter}, {parameter}) AND TO_DATE({parameter}, {parameter}) ORDER BY work_date
   ```
   ハッシュ: `sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-8

- 観測数: `1`
- 代表トレース: `1df82065-50be-4f84-b9e7-4bcfb46beeeb`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:delivery_date_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:delivery_date_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
5. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`
6. `SELECT` on `SHOP_REMOTE_ISLAND_POSTALS`
   ```sql
   SELECT {parameter} AS found FROM shop_remote_island_postals WHERE postal_code = {parameter}
   ```
   ハッシュ: `sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb`
7. `SELECT` on `SHOP_WORKING_DAYS`
   ```sql
   SELECT work_date, is_working FROM shop_working_days WHERE work_date BETWEEN TO_DATE({parameter}, {parameter}) AND TO_DATE({parameter}, {parameter}) ORDER BY work_date
   ```
   ハッシュ: `sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-9

- 観測数: `1`
- 代表トレース: `044eeabe-73f1-415f-94cd-041676542064`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:delivery_time_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:delivery_time_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
4. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

## POST /api/orders

- エントリポイントキー: `POST /api/orders`
- 観測リクエスト数: `11`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 201 | 5 |
| 422 | 6 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-2 | 2 | 422 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_ORDERS+SHOP_ORDER_ITEMS |
| pattern-7 | 2 | 422 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS |
| pattern-1 | 1 | 201 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_ORDERS+SHOP_ORDER_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT SHOP_DELAY_PREFECTURES → SELECT SHOP_REMOTE_ISLAND_POSTALS → SELECT SHOP_WORKING_DAYS → SELECT NO_BUSINESS_TABLE → SELECT SHOP_CUSTOMERS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → DELETE SHOP_CART_ITEMS → DELETE SHOP_RESERVATION_CART_ITEMS |
| pattern-3 | 1 | 201 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_ORDERS+SHOP_ORDER_ITEMS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT NO_BUSINESS_TABLE → SELECT SHOP_CUSTOMERS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → DELETE SHOP_CART_ITEMS → DELETE SHOP_RESERVATION_CART_ITEMS |
| pattern-4 | 1 | 422 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS |
| pattern-5 | 1 | 201 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT NO_BUSINESS_TABLE → SELECT SHOP_CUSTOMERS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → DELETE SHOP_CART_ITEMS → DELETE SHOP_RESERVATION_CART_ITEMS |
| pattern-6 | 1 | 201 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT NO_BUSINESS_TABLE → SELECT SHOP_CUSTOMERS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → INSERT SHOP_ORDER_ITEMS → INSERT SHOP_ORDER_ITEMS → DELETE SHOP_CART_ITEMS → DELETE SHOP_RESERVATION_CART_ITEMS |
| pattern-8 | 1 | 422 | SELECT SHOP_CUSTOMERS |
| pattern-9 | 1 | 201 | SELECT SHOP_CUSTOMERS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCTS → SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_ADDRESSES → SELECT SHOP_CUSTOMERS → SELECT NO_BUSINESS_TABLE → SELECT SHOP_CUSTOMERS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → DELETE SHOP_CART_ITEMS → DELETE SHOP_RESERVATION_CART_ITEMS |

### 振る舞いパターン: pattern-2

- 観測数: `2`
- 代表トレース: `07e15eab-81b9-4798-9722-0f628dbc058d`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_ORDERS, SHOP_ORDER_ITEMS`
   ```sql
   SELECT oi.product_code, o.status
             FROM shop_orders o JOIN shop_order_items oi ON oi.order_id = o.id
             WHERE o.customer_id = {parameter}
               AND o.status <> {parameter}
               AND REPLACE(oi.product_code, {parameter}, {parameter}) = REPLACE({parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-7

- 観測数: `2`
- 代表トレース: `4b47862b-f5ad-4fe4-9fd1-a931eaa50778`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:variety_bundle_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x2 -> CUSTOM:variety_bundle_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-1

- 観測数: `1`
- 代表トレース: `ce0a6a17-ac5b-45f6-a5c2-c5c095c6aa8e`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> SELECT:SHOP_DELAY_PREFECTURES:sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb -> SELECT:SHOP_REMOTE_ISLAND_POSTALS:sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb -> SELECT:SHOP_WORKING_DAYS:sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308 -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_ORDERS, SHOP_ORDER_ITEMS`
   ```sql
   SELECT oi.product_code, o.status
             FROM shop_orders o JOIN shop_order_items oi ON oi.order_id = o.id
             WHERE o.customer_id = {parameter}
               AND o.status <> {parameter}
               AND REPLACE(oi.product_code, {parameter}, {parameter}) = REPLACE({parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c`
6. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
7. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
8. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
9. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
10. `SELECT` on `SHOP_DELAY_PREFECTURES`
   ```sql
   SELECT {parameter} AS found FROM shop_delay_prefectures WHERE prefecture = {parameter} AND active = {parameter}
   ```
   ハッシュ: `sha256:3ee691eeb5b5e22ca2a55f615b5bd1dd65709965982b399538c017f0716c58cb`
11. `SELECT` on `SHOP_REMOTE_ISLAND_POSTALS`
   ```sql
   SELECT {parameter} AS found FROM shop_remote_island_postals WHERE postal_code = {parameter}
   ```
   ハッシュ: `sha256:6a30ddf1a9214cc279fe7a7fa4da1b4f31a39a500d7321f3c495011d9053feeb`
12. `SELECT` on `SHOP_WORKING_DAYS`
   ```sql
   SELECT work_date, is_working FROM shop_working_days WHERE work_date BETWEEN TO_DATE({parameter}, {parameter}) AND TO_DATE({parameter}, {parameter}) ORDER BY work_date
   ```
   ハッシュ: `sha256:31790135421304c8f183ec89ff9cf58b93f163854609f014adc01a76dc034308`
13. `SELECT` on ``
   ```sql
   SELECT shop_orders_seq.NEXTVAL AS id FROM dual
   ```
   ハッシュ: `sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd`
14. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
15. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
16. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
17. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555`
18. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_ORDERS | 1 |
| INSERT | SHOP_ORDER_ITEMS | 1 |
| DELETE | SHOP_CART_ITEMS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-3

- 観測数: `1`
- 代表トレース: `f342e8d4-ddc7-4ac5-be0f-574808d751c7`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_ORDERS+SHOP_ORDER_ITEMS:sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c -> CUSTOM:purchase_limit_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_ORDERS, SHOP_ORDER_ITEMS`
   ```sql
   SELECT oi.product_code, o.status
             FROM shop_orders o JOIN shop_order_items oi ON oi.order_id = o.id
             WHERE o.customer_id = {parameter}
               AND o.status <> {parameter}
               AND REPLACE(oi.product_code, {parameter}, {parameter}) = REPLACE({parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:1ff2859f7be70ce1dbcbe3e4d18d20f3993e62fdc11b0878aea2ecf73a8b0d9c`
6. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
7. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
8. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
9. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
10. `SELECT` on ``
   ```sql
   SELECT shop_orders_seq.NEXTVAL AS id FROM dual
   ```
   ハッシュ: `sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd`
11. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
12. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
13. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
14. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555`
15. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_ORDERS | 1 |
| INSERT | SHOP_ORDER_ITEMS | 1 |
| DELETE | SHOP_CART_ITEMS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-4

- 観測数: `1`
- 代表トレース: `7d034d7d-5811-4c68-a7c9-cc1ea85c4a6b`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:purchase_limit_rejected -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:purchase_limit_rejected -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-5

- 観測数: `1`
- 代表トレース: `6e2fb774-730c-4da3-a602-e3724dc25cd8`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:point_exchange_checked -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
6. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
7. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
8. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
9. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
10. `SELECT` on ``
   ```sql
   SELECT shop_orders_seq.NEXTVAL AS id FROM dual
   ```
   ハッシュ: `sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd`
11. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
12. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
13. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
14. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555`
15. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_ORDERS | 1 |
| INSERT | SHOP_ORDER_ITEMS | 1 |
| DELETE | SHOP_CART_ITEMS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-6

- 観測数: `1`
- 代表トレース: `4fcdc48f-42e8-40fc-a6ca-1d8c60f7d056`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> CUSTOM:variety_bundle_validated -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 x3 -> CUSTOM:variety_bundle_validated -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 x3 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
6. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
7. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
8. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
9. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
10. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
11. `SELECT` on ``
   ```sql
   SELECT shop_orders_seq.NEXTVAL AS id FROM dual
   ```
   ハッシュ: `sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd`
12. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
13. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
14. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
15. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
16. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
17. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555`
18. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_ORDERS | 1 |
| INSERT | SHOP_ORDER_ITEMS | 3 |
| DELETE | SHOP_CART_ITEMS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |

### 振る舞いパターン: pattern-8

- 観測数: `1`
- 代表トレース: `1536e251-1953-4fd8-8bba-529f7fb425bc`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:checkout_blocked -> STATUS:422`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:checkout_blocked -> STATUS:422`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-9

- 観測数: `1`
- 代表トレース: `25924a56-cc7e-41ff-981c-c899ae2ce4ba`
- シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`
- 圧縮シグネチャ: `SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCTS:sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99 -> SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_ADDRESSES:sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415 -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> CUSTOM:shipping_method_selected -> CUSTOM:payment_method_filtered -> CUSTOM:free_shipping_applied -> SELECT:NO_BUSINESS_TABLE:sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd -> SELECT:SHOP_CUSTOMERS:sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808 -> DELETE:SHOP_CART_ITEMS:sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555 -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb -> CUSTOM:order_created -> STATUS:201`

**SQL フロー:**

1. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
2. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
3. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
4. `SELECT` on `SHOP_PRODUCTS`
   ```sql
   SELECT * FROM shop_products WHERE code = {parameter}
   ```
   ハッシュ: `sha256:53288a6059c7e294843e6d5f317663e2f59668230e6349124483ca0f76fd5f99`
5. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
6. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
7. `SELECT` on `SHOP_ADDRESSES`
   ```sql
   SELECT * FROM shop_addresses WHERE id = {parameter}
   ```
   ハッシュ: `sha256:07affa8410adddef3076894adc9853adec5c028ba6d1414c24af6b62e342d415`
8. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
9. `SELECT` on ``
   ```sql
   SELECT shop_orders_seq.NEXTVAL AS id FROM dual
   ```
   ハッシュ: `sha256:b80844ea55b080932ef34e1f3da4ac3a8ade227eaf2c5dad5bd2b80f768287dd`
10. `SELECT` on `SHOP_CUSTOMERS`
   ```sql
   SELECT * FROM shop_customers WHERE id = {parameter}
   ```
   ハッシュ: `sha256:cf79a70fea6ab906953ad0d1cf63b727892417a6dcbdb8dca5cb46866a3f9189`
11. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
12. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
                 VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:4c9b053bfe506f4352c160d451b217f6f8be93633c0be3438ca04b073db77808`
13. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:50edcc988aeb43aaf9de214ef60efb79270f643b32861ee0964e95533d115555`
14. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items WHERE cart_id = {parameter}
   ```
   ハッシュ: `sha256:b532f4c2442ae0455c1e297d390f185d2e4a201746715c604f10e14183ec91cb`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| INSERT | SHOP_ORDERS | 1 |
| INSERT | SHOP_ORDER_ITEMS | 1 |
| DELETE | SHOP_CART_ITEMS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |

## GET /api/cart

- エントリポイントキー: `GET /api/cart`
- 観測リクエスト数: `5`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 200 | 5 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-1 | 4 | 200 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS |
| pattern-2 | 1 | 200 | SELECT SHOP_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS → SELECT SHOP_PRODUCT_COMPONENTS → SELECT SHOP_PRODUCT_COMPONENTS |

### 振る舞いパターン: pattern-1

- 観測数: `4`
- 代表トレース: `88f5df8b-50d3-48de-9766-ed30a48b2e1b`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> STATUS:200`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> STATUS:200`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`

**更新操作:**

_(なし — 読み取り専用パターン)_

### 振る舞いパターン: pattern-2

- 観測数: `1`
- 代表トレース: `6102b07c-f772-4343-897d-8362b7277719`
- シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCT_COMPONENTS:sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e -> CUSTOM:set_components_loaded -> SELECT:SHOP_PRODUCT_COMPONENTS:sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e -> CUSTOM:set_components_loaded -> STATUS:200`
- 圧縮シグネチャ: `SELECT:SHOP_CART_ITEMS+SHOP_PRODUCTS:sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328 -> SELECT:SHOP_RESERVATION_CART_ITEMS+SHOP_PRODUCTS:sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d -> SELECT:SHOP_PRODUCT_COMPONENTS:sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e -> CUSTOM:set_components_loaded -> SELECT:SHOP_PRODUCT_COMPONENTS:sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e -> CUSTOM:set_components_loaded -> STATUS:200`

**SQL フロー:**

1. `SELECT` on `SHOP_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:4fdc62e4dcef830a666b781722f4f0397909545b37fdb4f6520f3ab3f9ff6328`
2. `SELECT` on `SHOP_RESERVATION_CART_ITEMS, SHOP_PRODUCTS`
   ```sql
   SELECT ci.cart_id, ci.customer_id, ci.product_code, ci.quantity, ci.unit_price, ci.is_gift, p.name, p.price, p.is_set, p.is_reserved, p.is_point_exchange, p.point_cost, p.is_variety, p.variety_group
             FROM shop_reservation_cart_items ci JOIN shop_products p ON p.code = ci.product_code
             WHERE ci.cart_id = {parameter}
             ORDER BY ci.id
   ```
   ハッシュ: `sha256:55ac9ee8a204e2ac1dbf0a8f024af6f07a0c776c17863097a0e98fac0081dd4d`
3. `SELECT` on `SHOP_PRODUCT_COMPONENTS`
   ```sql
   SELECT component_code, component_name FROM shop_product_components WHERE parent_code = {parameter} ORDER BY sort_order
   ```
   ハッシュ: `sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e`
4. `SELECT` on `SHOP_PRODUCT_COMPONENTS`
   ```sql
   SELECT component_code, component_name FROM shop_product_components WHERE parent_code = {parameter} ORDER BY sort_order
   ```
   ハッシュ: `sha256:19d8f8952adb7e2200a133f85716dfe42573fd08db865053b6dd81e584abe35e`

**更新操作:**

_(なし — 読み取り専用パターン)_

## POST /api/test/reset

- エントリポイントキー: `POST /api/test/reset`
- 観測リクエスト数: `1`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 200 | 1 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-1 | 1 | 200 | DELETE SHOP_ORDER_ITEMS → DELETE SHOP_ORDERS → DELETE SHOP_RESERVATION_CART_ITEMS → DELETE SHOP_CART_ITEMS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS → INSERT SHOP_ORDERS → INSERT SHOP_ORDER_ITEMS |

### 振る舞いパターン: pattern-1

- 観測数: `1`
- 代表トレース: `83a16e6f-926e-43df-973b-2b9ba37e0f5e`
- シグネチャ: `DELETE:SHOP_ORDER_ITEMS:sha256:27683ecf221fbe864dadc5d85c2210e936b418f134a3dd54a022bb22f06d4e91 -> DELETE:SHOP_ORDERS:sha256:4677df1403bc309fa500c016eb5d138083df225d3ceaea51d3dc36196817fa1a -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:32660c5d9d5fec7a6a3cd9599bdc305c0bb38b591a6505a2dfea614d59533329 -> DELETE:SHOP_CART_ITEMS:sha256:ebb211248ecdd6796536f42cdf27559c6b0eff1079a75cbb101b0a8f201a0df6 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d -> CUSTOM:fixtures_reset -> STATUS:200`
- 圧縮シグネチャ: `DELETE:SHOP_ORDER_ITEMS:sha256:27683ecf221fbe864dadc5d85c2210e936b418f134a3dd54a022bb22f06d4e91 -> DELETE:SHOP_ORDERS:sha256:4677df1403bc309fa500c016eb5d138083df225d3ceaea51d3dc36196817fa1a -> DELETE:SHOP_RESERVATION_CART_ITEMS:sha256:32660c5d9d5fec7a6a3cd9599bdc305c0bb38b591a6505a2dfea614d59533329 -> DELETE:SHOP_CART_ITEMS:sha256:ebb211248ecdd6796536f42cdf27559c6b0eff1079a75cbb101b0a8f201a0df6 -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d -> INSERT:SHOP_ORDERS:sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa -> INSERT:SHOP_ORDER_ITEMS:sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d -> CUSTOM:fixtures_reset -> STATUS:200`

**SQL フロー:**

1. `DELETE` on `SHOP_ORDER_ITEMS`
   ```sql
   DELETE FROM shop_order_items
   ```
   ハッシュ: `sha256:27683ecf221fbe864dadc5d85c2210e936b418f134a3dd54a022bb22f06d4e91`
2. `DELETE` on `SHOP_ORDERS`
   ```sql
   DELETE FROM shop_orders
   ```
   ハッシュ: `sha256:4677df1403bc309fa500c016eb5d138083df225d3ceaea51d3dc36196817fa1a`
3. `DELETE` on `SHOP_RESERVATION_CART_ITEMS`
   ```sql
   DELETE FROM shop_reservation_cart_items
   ```
   ハッシュ: `sha256:32660c5d9d5fec7a6a3cd9599bdc305c0bb38b591a6505a2dfea614d59533329`
4. `DELETE` on `SHOP_CART_ITEMS`
   ```sql
   DELETE FROM shop_cart_items
   ```
   ハッシュ: `sha256:ebb211248ecdd6796536f42cdf27559c6b0eff1079a75cbb101b0a8f201a0df6`
5. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
6. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d`
7. `INSERT` on `SHOP_ORDERS`
   ```sql
   INSERT INTO shop_orders (id, customer_id, address_id, email, shipping_method, payment_method, subtotal, shipping_fee, status, payment_status, delivery_date, delivery_time, created_at)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {db_time})
   ```
   ハッシュ: `sha256:318164c31ff31ce0c78aa164096c172424d0c6b1f5192dcd9373595a0077faaa`
8. `INSERT` on `SHOP_ORDER_ITEMS`
   ```sql
   INSERT INTO shop_order_items (order_id, product_code, name, quantity, unit_price, is_gift)
             VALUES ({parameter}, {parameter}, {parameter}, {parameter}, {parameter}, {parameter})
   ```
   ハッシュ: `sha256:243ecb6eae5218f5d4aebfea0585298bf4fd136950d13f57ed4f55638d6eaf8d`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| DELETE | SHOP_ORDER_ITEMS | 1 |
| DELETE | SHOP_ORDERS | 1 |
| DELETE | SHOP_RESERVATION_CART_ITEMS | 1 |
| DELETE | SHOP_CART_ITEMS | 1 |
| INSERT | SHOP_ORDERS | 2 |
| INSERT | SHOP_ORDER_ITEMS | 2 |

## POST /api/orders/{id}/cancel

- エントリポイントキー: `POST /api/orders/{id}/cancel`
- 観測リクエスト数: `1`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 200 | 1 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-1 | 1 | 200 | UPDATE SHOP_ORDERS |

### 振る舞いパターン: pattern-1

- 観測数: `1`
- 代表トレース: `c68ae9fc-7138-4eae-9dec-034ec307bcc2`
- シグネチャ: `UPDATE:SHOP_ORDERS:sha256:1863038827ff3b39ae8042d0e2e4527becd3616584a7a168c82a8951862a43fa -> CUSTOM:order_cancelled -> STATUS:200`
- 圧縮シグネチャ: `UPDATE:SHOP_ORDERS:sha256:1863038827ff3b39ae8042d0e2e4527becd3616584a7a168c82a8951862a43fa -> CUSTOM:order_cancelled -> STATUS:200`

**SQL フロー:**

1. `UPDATE` on `SHOP_ORDERS`
   ```sql
   UPDATE shop_orders SET status = {parameter} WHERE id = {parameter}
   ```
   ハッシュ: `sha256:1863038827ff3b39ae8042d0e2e4527becd3616584a7a168c82a8951862a43fa`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| UPDATE | SHOP_ORDERS | 1 |

## POST /api/payments/credit/callback

- エントリポイントキー: `POST /api/payments/credit/callback`
- 観測リクエスト数: `1`
- エラー数: `0`

### ステータスコード

| ステータス | 件数 |
|---|---:|
| 200 | 1 |

### エラー

_(なし)_

### 観測実行パターン

| パターン | 件数 | ステータス | SQL フロー |
|---|---:|---|---|
| pattern-1 | 1 | 200 | UPDATE SHOP_ORDERS |

### 振る舞いパターン: pattern-1

- 観測数: `1`
- 代表トレース: `2bf67724-30c0-4c9b-9327-b919f1f35315`
- シグネチャ: `UPDATE:SHOP_ORDERS:sha256:e9d0496bb5f057f414cb13941f44d70c8cd1d483de994d53a11d0a1a070bd6dc -> CUSTOM:credit_callback_recorded -> STATUS:200`
- 圧縮シグネチャ: `UPDATE:SHOP_ORDERS:sha256:e9d0496bb5f057f414cb13941f44d70c8cd1d483de994d53a11d0a1a070bd6dc -> CUSTOM:credit_callback_recorded -> STATUS:200`

**SQL フロー:**

1. `UPDATE` on `SHOP_ORDERS`
   ```sql
   UPDATE shop_orders SET payment_status = {parameter} WHERE id = {parameter}
   ```
   ハッシュ: `sha256:e9d0496bb5f057f414cb13941f44d70c8cd1d483de994d53a11d0a1a070bd6dc`

**更新操作:**

| 操作 | テーブル | 件数 |
|---|---|---:|
| UPDATE | SHOP_ORDERS | 1 |

