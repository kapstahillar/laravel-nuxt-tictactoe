# laravel-nuxt-tictactoe


## description
Tick tack toe application made with laravel backend and nuxt.js frontend

AI uses minmax algorithm for playing


## Installation


```
mv api/.env.example api/.env
mv frontend/.env.example frontend/.env
docker-compose build
docker-compose exec php php artisan migrate
docker-compose up
```
Access Localhost:3000 or what ever port has been set in you environment