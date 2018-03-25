Blog - fredrsf.ru
=====================

# Prerequisites

Install [Docker](https://www.docker.com/).

# To start

1. Create file `.env` in project root from `.env.dist`.

2. Run `docker-compose build` then `docker-compose up -d`.

3. Run `docker-compose exec php bash`, then:
  - `composer install --prefer-source --no-interaction`
  - `sf doctrine:migrations:migrate --no-interaction`
  
4. Open in your browser `http://localhost/`
