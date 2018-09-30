# IIS - Projekt

## Cíl projektu
Cílem projektu je implementovat informační systém s webovým rozhraním, podle návrhu provedeného v rámci předmětu Databázové systémy (IDS) pro zvolené zadání (případně zadání z předmětu IUS). Výjimku tvoří téma Internetový obchod (viz níže). Postup řešení by měl být následující:

  - Volba implementačního prostředí - databázového serveru a aplikační platformy
  - Implementace navrženého databázového schématu ve zvoleném DB systému
  - Návrh webového uživatelského rozhraní aplikace
  - Implementace vlastní aplikace

## Požadavky pro správnou funkci aplikace
  - PHP >= 7.1.3
  - Rozšíření OpenSSL PHP
  - Rozšíření PDO PHP
  - Rozšíření Mbstring PHP
  - Rozšíření Tokenizer PHP
  - Rozšíření XML PHP
  - Rozšíření Ctype PHP
  - Rozšíření JSON PHP
  - MySQL/MariaDB/PostgreSQL/SQLite/SQL Server

## Požadavky pro instalaci
  - Composer
  - NPM/yarn

## Postup instalace
Nejprve se naklonuje git repozitář:
```sh
$ git clone git@gitlab.paveljanko.eu:sainthrax/iis.git
```
Potom je třeba zkopírovat konfigurační soubor a upravit ho dle potřeby, především je třeba vygenerovat klíč pro šifrování
```sh
$ cd iis
$ cp .env.example .env
$ php artisan key:generate
```
Pak se stáhnou back-endové závislosti:
```sh
$ composer install
```
Migrují se tabulky a databáze se naplní ukázkovými daty:
```sh
$ php artisan migrate --seed
```
Poté se stáhnou front-endové závislosti:
```sh
$ npm install
```
Nakonec kompilace front-endových závislostí:
```sh
$ npm run prod
```
