<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/WillyFaq/Sedekah-Rombongan-Web/blob/main/public/assets/imgs/icon-300.png?raw=true" width="300" alt="Laravel Logo"></a></p>

## About Project

A simple and basic Crowdfunding Platform based on sedekahrombongan.com

## Requrement

1. PHP version 8.2 and above
2. Composer
3. MySql Database

## Instalation

-   Clone Project

```
git clone https://github.com/WillyFaq/Sedekah-Rombongan-Web.git
```

-   Go to the folder application

```
cd Sedekah-Rombongan-Web
```

-   Install dependencies

```
composer install
```

-   Copy `.env.example` to `.env`. open it and change database setting
-   Generate App Key

```
php artisan key:generate
```

-   Migrate database

```
php artisan migrate
```

-   Seed database

```
php artisan db:seed
```

-   link storage

```
php artisan storage:link
```

## Run server

```
php artisan serve --host 0.0.0.0
```

