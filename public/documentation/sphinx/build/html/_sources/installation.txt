************
Installation
************

Go to the project folder in the terminal and type::

$ ./dcp composer install --no-autoloader
$ ./dcp composer update
$ ./dcp project:install
$ ./dcp mysql
$ CREATE SCHEMA IF NOT EXISTS creativehothouse
$ DEFAULT CHARACTER SET utf8mb4 
$ DEFAULT COLLATE utf8mb4_unicode_ci;
$ exit
$ ./dcp artisan project:install

.. note::

  We recommend not running the seeder CryptocurrenciesHistorical for the hours it can take to insert millions of records. Execute it preferably using::

  ./dcp art db:seed --class="Modules\\\Cryptocurrency\\\Database\\\Seeders\\\CryptocurrenciesHistoricalTableSeeder"