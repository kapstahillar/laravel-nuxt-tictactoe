FROM nginx:stable-alpine

ADD ./nginx/ /etc/nginx/conf.d/

EXPOSE 8000

RUN mkdir -p /var/www/html