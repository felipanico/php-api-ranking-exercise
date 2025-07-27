## Setup

- cp .env.example .env

- docker compose build

- docker compose up -d

- docker compose exec php-fpm composer install

- docker compose exec -T mysql mysql -u [USUARIO] -p[SENHA] homestead < app/db/schema.sql

- docker compose exec -T mysql mysql -u [USUARIO] -p[SENHA] homestead < app/db/data.sql

- docker compose run --rm phpqa php-cs-fixer fix --dry-run --diff .
