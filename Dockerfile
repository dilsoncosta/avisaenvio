FROM php:8.2-fpm

# set your user name, ex: user=carlos
ARG user=yourusername
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    vim \
    cron \
    libzip-dev  # Install libzip-dev for zip extension

# Copy cronjob
COPY docker/php/cronjob /etc/cron.d/cronjob

# Ensure that the new line is present at the end of the cronjob file
RUN echo >> /etc/cron.d/cronjob

# Ensure proper permissions for the cronjob file
RUN chmod 0644 /etc/cron.d/cronjob

# Install Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Install zip extension using pecl
RUN pecl install -o -f zip \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www

# Copy custom PHP configurations
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Switch to non-root user
USER $user
