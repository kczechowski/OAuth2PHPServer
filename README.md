## Dependencies
* [slim](https://www.slimframework.com/) - framework
* [slim](https://www.slimframework.com/) - framework
* [illuminate/database](https://github.com/illuminate/database) - database query builder
* [phinx](https://phinx.org/) - database migrations and seeding
* [PHP dotenv](https://github.com/vlucas/phpdotenv) - loading environmental variables
* [cors-middleware](https://github.com/tuupola/cors-middleware) - CORS policy middleware

## Setup

```bash
composer install
```

Create .env file based on .env.example and put your own configuration
```bash
DB_DRIVER = "mysql"
DB_HOST = ""
DB_DBNAME = ""
DB_USERNAME = ""
DB_PASSWORD = ""
DB_CHARSET = "utf8"
DB_COLLATION = "utf8_unicode_ci"
DB_PREFIX = ""
```

Also edit phinx.yml and configure your database connection
```bash
[...]
development:
    adapter: mysql
    host: 10.10.10.10
    name: dev_db
    user: root
    pass: 'root'
    port: 3306
    charset: utf8
[...]
```

Run all migrations and seeds
```bash
vendor/bin/phinx migrate
vendor/bin/phinx seed:run
```