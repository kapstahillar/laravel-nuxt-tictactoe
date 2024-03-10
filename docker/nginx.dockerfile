FROM nginx:stable-alpine

ADD ./nginx/ /etc/nginx/conf.d/

RUN mkdir -p /var/www/html