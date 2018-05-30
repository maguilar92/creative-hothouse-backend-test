************
Installation
************

Go to the project folder in the terminal and type::

$ ./dcp composer install
$ ./dcp composer update
$ ./dcp project:install

.. note::

  We recommend not running the seeder CryptocurrenciesHistorical for the hours it can take to insert millions of records. Execute it preferably using::

  ./dcp art db:seed --class="Modules\\\Cryptocurrency\\\Database\\\Seeders\\\CryptocurrenciesHistoricalTableSeeder"