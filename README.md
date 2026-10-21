# SI POS Kasir (WebPOS Laravel)

Sistema Informasaun Ponto de Venda (POS) ba loja — versaun Laravel husi sistema WebPOS tuan (PHP procedural).

Aplikasaun ida ne'e uza **Laravel 13**, **AdminLTE 3.2.0**, no konekta ba **baze de dados MySQL** (porta padraun `3306`).

## Kona-ba Sistema

Sistema POS simples ne'ebé uza iha Timor-Leste, ho interfeis no notifikasaun hotu-hotu iha **Tetum**.

### Funsaun sira
- **Autentikasaun** — login, troka password, no kontrola asesu tuir nível uza-na'in
- **Dadu Baze** — jere Sasan (produtu), Supplier, no Kliente
- **Maksosak** — transaksaun sosa sasan (aumenta stok automátiku)
- **Makfa'an** — transaksaun fa'an sasan (hamenus stok automátiku + verifikasaun stok)
- **Relatoriu** — relatoriu Fa'an, Sosa, no Stok (PDF)
- **Struk & Barcode** — imprime struk no barcode
- **Utilizadores** — jere uza-na'in (Admin deit)

### Nível Uza-na'in
| Nível | Naran | Asesu |
|-------|-------|-------|
| 1 | Administrador | Asesu hotu-hotu (inklui jestaun uza-na'in) |
| 2 | Supervizor | Dadu Baze (Sasan, Supplier, Kliente) |
| 3 | Operador | Transaksaun no relatoriu deit |

## Teknolojia
- Laravel 13 / PHP 8.4
- AdminLTE 3.2.0 (Bootstrap 4)
- MySQL 8+ / 9.x
- `picqer/php-barcode-generator` (barcode)
- `setasign/fpdf` (relatoriu PDF)

## Instalasaun

```bash
# 1. Klona repositoriu
git clone <repo-url> WebPOS-Laravel
cd WebPOS-Laravel

# 2. Instala dependensia
composer install

# 3. Kopia konfigurasaun
copy .env.example .env
php artisan key:generate

# 4. Konfigura .env (baze de dados MySQL)
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=db_codinglinepos
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Importa baze de dados (tabela tbl_* presiza eziste ona)
#    Importa db_codinglinepos.sql ba MySQL

# 6. Hahu server
php artisan serve
```

Loke `http://127.0.0.1:8000`.

## Toku Sesaun iha browser ida deit (multi-session)

Buka `http://localhost/WebPOS-Laravel` — pagina launcher sei hatudu **toku karta sesaun**.
Klik **"Loke Toku Sesaun"** (ka kada karta) sei loke toku jwindow, ita bele tama
iha sesaun diferente iha kada jwindow, iha **browser ida deit**.

| Slot | URL | Uza-na'in | Nível |
|------|-----|-----------|-------|
| 1 | `/WebPOS-Laravel/s1/...` | `ediko` | Administrator |
| 2 | `/WebPOS-Laravel/s2/...` | `riana` | Supervisor |
| 3 | `/WebPOS-Laravel/s3/...` | `fabio` | Operator |

### Bainhira nune'e iha buat iha browser ida deit?

Browser ida deit Normally iha hakarek **cookie ida deit** ba sesaun — hodi
login foun, sesaun anterior sei substituidu. Ita bele resolve problema ida ne'e
ho **"slot"**: kada slot iha nia **path** (`/s1`, `/s2`, `/s3`) no iha nia
**naran cookie** propriu, hodi browser iha hakarek cookie ida-ida ba kada slot.

| Arquivo | Funsaun |
|---|---|
| `app/Http/Middleware/SessionSlot.php` | Detekta slot, define naran + path cookie, ajusta base URL |
| `resources/views/launcher.blade.php` | Pagina launcher (toku karta sesaun) |

> **Nota:** Middleware ida ne'e tenke iha **global middleware** (la iha grupu
> `web`), tanba grupu `web` sei execute **depis** router matek rota — se
> middleware iha grupu `web`, path info bele keta mosu iha laran.

Rota sira hotu-hotu funsiona hanesan: link sira hotu-hotu sei kontinue iha
slot (`/WebPOS-Laravel/s2/dashboard`), no asesu ba asesu sira sensibel
(`/.env`, `/vendor/`, ...) sei blokea iha slot sira mos.

## Akses liu WAMP/Apache (URL loku: `http://localhost/WebPOS-Laravel`)

Sistema bele serve iha **subdirectory** — `http://localhost/WebPOS-Laravel` — **sem** `/public`.
Ita kria ona:

| Arquivo | Funsaun |
|---|---|
| `index.php` (raiz) | Front controller. Delega ba `public/index.php` |
| `.htaccess` (raiz) | Blokeia asesu kodigu fonte, serve asseti husi `public/`, manda ba `index.php` |

Kualidade URL sira **husi host ne'ebé ita uza** — se ita loke
`http://192.168.1.32/WebPOS-Laravel`, link hotu-hare sei husi IP ne'e. Hodi
iha **dispositivu seluk** iha rede loja, buka husi IP komputador POS.
Reserva IP iha router atu IP la muda.

### 1. Konfigurasaun Apache (WAMP64)

Document root ba `localhost` tenke ser `${INSTALL_DIR}/www` (default husi WAMP),
ita bele edita `C:\wamp64\bin\apache\apache2.4.62.1\conf\extra\httpd-vhosts.conf`:

```apache
<VirtualHost *:80>
  ServerName localhost
  ServerAlias localhost
  DocumentRoot "${INSTALL_DIR}/www"
  <Directory "${INSTALL_DIR}/www/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>
```

> ⚠️ Salva arkivu **sem BOM** (UTF-8 *without* BOM). Se arkivu iha BOM, Apache parse fail
> no ita hatudu **403** iha hotu-hotu website localhost. Konferi ho:
> `Format-Hex C:\wamp64\bin\apache\apache2.4.62.1\conf\extra\httpd-vhosts.conf | Select-Object -First 1`
> — se bytes primeiru `EF BB BF`, iha BOM, tenke hamoos.

**2. Restart Apache** (WAMP tray → Restart All Services, ka `Restart-Service wampapache64`).

**3. Konfigura `APP_URL` iha `.env`:**

```
APP_URL=http://localhost/WebPOS-Laravel
```

Loke `http://localhost/WebPOS-Laravel` — URL limpo, sem `/public`.

### Seguridade (`.htaccess`)

`.htaccess` iha raiz **blokeia** asesu ba:

- `.env` (password baze de dados), `composer.json`, `composer.lock`, `AGENTS.md`, `package.json`
- direktóriu `app/`, `bootstrap/`, `config/`, `database/`, `lang/`, `resources/`, `routes/`, `storage/`, `tests/`, `vendor/`, `.git/`

Konkretiza: `http://<IP>/WebPOS-Laravel/.env` → **403**.

### Baze de dados: blokeia asesu husi rede

`my.ini` (`C:\wamp64\bin\mysql\mysql9.1.0\my.ini`) tenke iha:

```ini
[mysqld]
bind-address=127.0.0.1
```

Database seiacessu **deit husi komputador ida**. Firewall rule ba `mysqld` mosi tenke
desativadu. Aplikasaun kontinua funsiona tanba iha koneksaun loopback.

## Backup baze de dados (automatiku)

| Arquivo | Funsaun |
|---|---|
| `backup-db.ps1` | Kria dump `.sql` iha `C:\wamp64\backups\db\`, rotasaun 30 dias |
| `backup-loop.ps1` | Loop: roda backup kada 24 horas |
| `C:\wamp64\backups\my.cnf` | Kredensial MySQL (password la mosu iha command line) |
| `C:\wamp64\backups\backup.log` | Log |

Backup iha tua boot Windows:
`%APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup\WebPOS Backup Loop.vbs`

> **Nota:** Windows Task Scheduler iha komputador ida ne'e **laika** task (ihin
> "Queued"). Hodi nune'e, backup iha direitu ona iha Start-up folder, no
> `backup-loop.ps1` iha kontrolu bug running duple.

**Restaura dadus:**

```powershell
& "C:\wamp64\bin\mysql\mysql9.1.0\bin\mysql.exe" -u root -p -h 127.0.0.1 -P 3306 db_codinglinepos < "C:\wamp64\backups\db\pos_2026-10-22_0900.sql"
```

**Roda backup manual:**

```powershell
powershell -ExecutionPolicy Bypass -File C:\wamp64\www\WebPOS-Laravel\backup-db.ps1
```

## Estrutura Baze de Dados

Sistema ida ne'e uza baze de dados ne'ebé eziste ona (la uza migration):

- `tbl_user` — uza-na'in
- `tbl_barang` — sasan/produtu
- `tbl_supplier` — fornecedor
- `tbl_customer` — kliente
- `tbl_beli_head` / `tbl_beli_detail` — transaksaun sosa
- `tbl_jual_head` / `tbl_jual_detail` — transaksaun fa'an

## Lisensa

Projetu ida ne'e ba objetivu edukasaun no jestaun loja.
