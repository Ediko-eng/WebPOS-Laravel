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

## Akses liu WAMP/Apache (URL loku formatu: `http://webpos.local`)

Laravel tenke **document root** apunta ba pasta `public/`. Ita bele konfigura **Virtual Host** iha Apache (WAMP64):

**1. Kuza ka edita `C:\wamp64\bin\apache\apache2.4.62.1\conf\extra\httpd-vhosts.conf`:**

```apache
# Virtual Hosts
#
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

<VirtualHost *:80>
  ServerName webpos.local
  ServerAlias www.webpos.local
  DocumentRoot "C:/wamp64/www/WebPOS-Laravel/public"
  <Directory "C:/wamp64/www/WebPOS-Laravel/public">
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

**2. Hakama iha Windows hosts file** (`C:\Windows\System32\drivers\etc\hosts`, iha hakarak admin):

```
127.0.0.1 webpos.local www.webpos.local
```

**3. Restart Apache** (WAMP tray → Restart All Services, ka `Restart-Service wampapache64`).

**4. Konfigura `APP_URL` iha `.env`:**

```
APP_URL=http://webpos.local
```

Loke `http://webpos.local` — URL limpo, sem `/public`.

> **Nota:** Laravel labele funsiona iha subdirectory (`/WebPOS-Laravel/...`) tanpa
> Virtual Host, tanba Symfony labele detekta base path. Uza `webpos.local` ka
> `http://localhost/WebPOS-Laravel/public`.

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
