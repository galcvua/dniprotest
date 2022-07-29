# DNIPROTEST
Symfony 5 (php 8) Api Rest application.
## Installation
Clone the project from github or unpack the archive with the project. Go to your project folder, and edit DATABASE_URL in .env file if PostgreSQL is installed locally.
If you are using docker, skip the previous step and just run 
```console
docker-compose up database -d 
```
in the console.
Run
```console
symfony console doctrine:migrations:migrate 
```
to setup database.

The symfony binary must be installed on your system in order to select the correct php version automatically. Otherwise, hereinafter use php bin/console instead of symfony console.

## Testing
Now you can import data.
```console
symfony console category:import json/category.json
symfony console product:import json/product.json
```
You can try importing invalid data:
```console
symfony console category:import json/badcategory.json
symfony console product:import json/badproduct.json
```

Of course, you can perform automated testing.
Prepare your test environment.
```console
symfony console doctrine:database:create --env=test
symfony console doctrine:migrations:migrate -n --env=test
```
Then run tests:
```console
symfony php bin/phpunit tests/Commands/ProductImportTest.php
symfony php bin/phpunit tests/Commands/CategoryImportTest.php
```
## Api
Up your web server. In development environment just run
```console
symfony serve
```
in project directory.

Then take access to API in your browser http://localhost:8000/api
Or setup your server with docker:
```console
docker-compose build
docker-compose up -d 
```
Then go http://localhost:8001/api
