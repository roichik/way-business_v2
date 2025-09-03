FROM nginx:mainline-alpine

RUN apk add --update netcat-openbsd && rm -rf /var/cache/apk/*
COPY ./default.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
VOLUME ["/var/www/html", "/opt/nginx/config"]
