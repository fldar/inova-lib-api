## API
##### Instal with docker
- edit the PROJECT_DIR in .env to you real project dir.
- do the same in '.docker/nginx/symfony.conf' 'root:'
- do the same in '.docker/php-fpm/Dockerfile' 'WORKDIR'
- run `docker-compose build`
- run `docker-compose up -d`
- run `docker-compose exec T api-php composer install`
- open `localhost:8051`

##### Run bash in Container
- docker exec -it api-php /bin/sh

##### Config DB
- php bin/console doctrine:database:drop --force --if-exists --env=dev
- php bin/console doctrine:database:create --env=dev
- php bin/console doctrine:migrations:migrate --env=dev

##### Create Migration
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate --env=dev

##### Make DataFixture
- php bin/console make:fixtures
- php bin/console doctrine:fixtures:load


##### UniTests
- php bin/phpunit --coverage-html reports/
- php bin/phpunit --coverage-text

##### PSR12
- ./vendor/bin/phpcs src/ --standard=PSR12 -p --ignore=*/Migrations/*
