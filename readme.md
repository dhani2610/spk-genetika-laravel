<p align="center"><img src="https://www.grootech.id/frontAsset/img/logo_groot.png"></p>


## Requirement

1. Laragon (Min Version  Apache 2.4, PHP 7.4) : https://laragon.org/download/
2. Composer (Min Version 1.10.20) : https://getcomposer.org/download/
3. Node Js (Min Version 12.18.3) : https://nodejs.org/en/download/
4. Posgresql (Min Version 12) : https://www.enterprisedb.com/download-postgresql-binaries

## Installation

1. Clone the repo
   ```sh
   git clone https://github.com/sahriramadan000/project-profile-dosen.git
   ```
2. Install vendor packages
   ```sh
   composer install
   
   create file .env copy from .env-example
   ```
3. Create database in postgresql
  
4. Migrate table
   ```sh
   php artisan migrate
   ```
5. Create account with seeder database
   ```sh
   php artisan db:seed
   ```