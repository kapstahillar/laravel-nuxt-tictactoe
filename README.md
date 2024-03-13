# laravel-nuxt-tictactoe


## description
Tick tack toe application made with laravel backend and nuxt.js frontend

AI uses minmax algorithm for playing


## Installation


```
cp api/.env.example api/.env
cp frontend/.env.example frontend/.env
docker-compose build
docker-compose up -d
docker-compose exec php /var/www/html/artisan migrate

```
Access Localhost:3000 or what ever port has been set in you environment