# laravel-nuxt-tictactoe


## description
Tick tack toe application made with laravel backend and nuxt.js frontend

AI uses minmax algorithm for playing


## Installation


Update env values in docker-compose: 
-FRONTEND_URL
-NUXT_PUBLIC_BASE_URL
-NUXT_PUBLIC_API_BASE_URL

```
cp api/.env.example api/.env
cp frontend/.env.example frontend/.env
docker-compose build
docker-compose up -d
docker-compose exec php /var/www/html/artisan migrate
```
Access Localhost:3000 or what ever port has been set in you environment