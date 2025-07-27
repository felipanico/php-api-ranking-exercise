# PHP API Ranking Exercise

This repository contains a study project that implements a RESTful API for record ranking using **pure PHP**, **FastRoute**, **MySQL** and **Docker**.

> ⚠️ This project is for learning purposes.

---

## Technologies

- PHP 8.x  
- MySQL 8  
- Composer  
- FastRoute  
- Docker / Docker Compose  
- php-cs-fixer (via phpqa)  

---

## 🚀 Instructions

### 1. Clone

```bash
git clone git@github.com:felipanico/php-api-ranking-exercise.git
cd php-api-ranking-exercise

```

### 2. Setup

```bash

cp .env.example .env

docker compose build

docker compose up -d

docker compose exec php-fpm composer install

docker compose exec -T mysql mysql -u [USER] -p[PASS] homestead < app/db/schema.sql

docker compose exec -T mysql mysql -u [USER] -p[PASS] homestead < app/db/data.sql

```

### 3. Quality Code

```bash

docker compose run --rm phpqa php-cs-fixer fix --dry-run --diff .

```

### 4. Tests

```bash

docker compose run --rm phpunit --colors=always

```

