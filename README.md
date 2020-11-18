## API
##### Instal with docker
- edit the PROJECT_DIR in .env to you real project dir.
- do the same in '.docker/nginx/symfony.conf' 'root:'
- do the same in '.docker/php-fpm/Dockerfile' 'WORKDIR'
- run `docker-compose build`
- run `docker-compose up -d`
- run `docker-compose exec T php composer install`
- acces `localhost:8051`
