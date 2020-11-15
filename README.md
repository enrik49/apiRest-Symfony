# apiRest-Symfony

Clone git repository

Install the project dependencies:
### `composer install`

Change the file .env to connect to your database. The following sentence is for connection to the database, replace fields (dbuser,password, dbname):

### `DATABASE_URL=mysql://<dbuser>:<password>@127.0.0.1:3306/<dbname>?serverVersion=5.7`

Create tables:

### `php bin/console doctrine:migration:migrate`

And start the server:

### `symfony server:start`
