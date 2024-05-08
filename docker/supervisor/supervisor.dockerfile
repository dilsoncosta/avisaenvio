FROM php:8.2-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

RUN mkdir -p "/etc/supervisor/logs"

# Cria o diretório de logs para o Supervisor
RUN mkdir -p "/var/www/docker/supervisor/logs"

COPY supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

