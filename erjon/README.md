# Projekt (rregulluar - version bazë)

Përmban:
- Projekti origjinal (si e ngarkove).
- `config.php` i ri me lidhje PDO (editoni vlerat e DB sipas mjedisit tuaj).
- `admin/` - panel i thjeshtë admin për menaxhim (login, users, categories, products, sales).
- SQL-të origjinale që keni ngarkuar: `users.sql`, `products.sql`, `categories.sql`, `subcategories.sql`, `sales.sql`.

**Si ta vendosësh në XAMPP / Laragon**
1. Krijo një database bosh, p.sh. `shopdb`.
2. Importoni SQL-et (`users.sql` etj.) në phpMyAdmin në database `shopdb`.
   - Vini re: `users` table nuk ka fushë `password`. Nëse dëshironi login me password për secilin user, shtoni një kolonë `password VARCHAR(255)` dhe vendosni `password_hash('pwd', PASSWORD_DEFAULT)` për vlerat.
3. Editoni `config.php` dhe vendosni `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` sipas nevojës.
4. Nga shfletuesi: hapni `http://localhost/<folderi>/admin/login.php`
   - Default admin credentials: **admin / admin123** (ndrysho menjëherë në config.php).
5. Përdoreni panelin për të parë users, categories, products, subcategories, sales.

**Çfarë përfshiu ky përditësim**
- Lidhje PDO me error handling.
- Panel admin minimal për shikim dhe shtim (users).
- Placeholder për CRUD të produkteve/kategorive/subkategorive/shitjeve — mund t'i zgjeroni lehtësisht.
- README me udhëzime.

Nëse dëshironi, unë mund të:
- Shtoj fushë `password` tek tabela `users` dhe të migroj/inkluodoj një formular për të krijuar user me password (hash).
- Implementoj full CRUD (edit/delete) dhe upload për imazhe produktesh.
- Integrimin e `Bootstrap` për UI më të mirë.

Më thuaj çfarë preferon të bëjmë më pas.
