FROM nginx:alpine

ADD ./docker/nginx_prd/default.conf /etc/nginx/conf.d/default.conf

# Install openssl
RUN apk update && \
    apk add --no-cache openssl

# Generate self-signed SSL certificate
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/nginx-selfsigned.key \
    -out /etc/ssl/certs/nginx-selfsigned.crt \
    -subj "/C=BR/ST=MG/L=Rio Casca/O=Avisa APP/CN=system@avisa.app.br"

# Copy public web files
COPY ./public /var/www/public
