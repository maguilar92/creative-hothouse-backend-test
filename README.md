[![Build Status](https://travis-ci.org/maguilar92/creative-hothouse-backend-test.svg?branch=master)](https://travis-ci.org/maguilar92/creative-hothouse-backend-test)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5d5452b310e64219b0e07777de27b69a)](https://www.codacy.com/app/mario-hoyvoy/creative-hothouse-backend-test?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=maguilar92/creative-hothouse-backend-test&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://github.styleci.io/repos/134744980/shield?branch=master)](https://github.styleci.io/repos/134744980)

# Requirements

Docker client

[Docker for MAC](https://docs.docker.com/docker-for-mac/)

[Docker for Linux](https://docs.docker.com/compose/install/)

[Docker for windows](https://docs.docker.com/docker-for-windows/)

# Installation

I recommend not running the seeder CryptocurrenciesHistorical for the hours it can take to insert millions of records. Execute it preferably using:

> ./dcp art db:seed --class="Modules\\\Cryptocurrency\\\Database\\\Seeders\\\CryptocurrenciesHistoricalTableSeeder"

Start docker and execute this commands on the project root:

> cp .env.example .env

> ./dcp build

> ./dcp up

> ./dcp composer install --no-autoloader

> ./dcp composer update

> ./dcp mysql

````sql
CREATE SCHEMA IF NOT EXISTS creativehothouse
DEFAULT CHARACTER SET utf8mb4 
DEFAULT COLLATE utf8mb4_unicode_ci;
exit
````
> ./dcp artisan project:install

# Documentation links

When the project is installed you can access to project documentation from these links.

[Sphinx](https://localhost/documentation/sphinx/build/html/index.html)

[Sami](https://localhost/documentation/sami/build/master/)

[Api](https://localhost/documentation/api/)