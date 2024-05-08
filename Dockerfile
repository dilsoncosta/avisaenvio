# Use PHP 8.2 FPM base image
FROM php:8.2-fpm

# Defina o nome de usuário e ID do usuário
ARG user=avisoenvia
ARG uid=1000

# Instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg \
    cron \
    sudo \
    procps \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instale o Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instale as extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets pdo

# Instale o redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Obtenha o Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crie um usuário do sistema para executar comandos do Composer e Artisan
RUN useradd -m -u $uid $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Copie as configurações PHP personalizadas
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Configure o diretório de trabalho
WORKDIR /var/www