FROM nginx:stable-alpine

ADD ./nginx/ /etc/nginx/conf.d/

EXPOSE 80

RUN mkdir -p /var/www/html