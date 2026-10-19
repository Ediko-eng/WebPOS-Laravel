# SI POS Kasir (WebPOS Laravel)

Sistema Informasaun Ponto de Venda (POS) ba loja — versaun Laravel husi sistema WebPOS tuan (PHP procedural).

Aplikasaun ida ne'e uza **Laravel 13**, **AdminLTE 3.2.0**, no konekta ba **baze de dados MySQL/MariaDB** ne'ebé iha ona (tabela `tbl_*`).

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
- MySQL / MariaDB
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

# 4. Konfigura .env (baze de dados)
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3307
#    DB_DATABASE=db_codinglinepos
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Importa baze de dados (tabela tbl_* presiza eziste ona)
#    Importa db_codinglinepos.sql ba MariaDB

# 6. Hahu server
php artisan serve
```

Loke `http://127.0.0.1:8000`.

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
