FROM php:8.1.5-fpm-bullseye

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libicu-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    git \
    cron \
    zip unzip libzip-dev \
    ca-certificates supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN echo "deb https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    apt-get install php8.1-zip php8.1-mbstring

RUN pecl install redis swoole
RUN docker-php-ext-install zip pdo_mysql exif pcntl bcmath gd intl soap
RUN docker-php-ext-enable redis swoole
RUN docker-php-ext-configure intl
# RUN docker-php-ext-configure zip --with-libzip

# Configure PHP
RUN sed -i -e "s/upload_max_filesize = .*/upload_max_filesize = 1G/g" \
        -e "s/post_max_size = .*/post_max_size = 1G/g" \
        -e "s/memory_limit = .*/memory_limit = 512M/g" \
        /usr/local/etc/php/php.ini-production \
        && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Set working directory
WORKDIR /app
# COPY SOURCE CODE
# COPY . /app
# RUN chown -R www-data:www-data /app

# Get latest Composer and install
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Setup Crontab
RUN touch crontab.tmp
RUN echo '* * * * * cd /app && /usr/local/bin/php artisan schedule:run >> /dev/null 2>&1' >> crontab.tmp
RUN crontab crontab.tmp
RUN rm -rf crontab.tmp

COPY ./docker/php-fpm/zzz-docker.conf /usr/local/etc/php-fpm.d/zzz-docker.conf
COPY ./docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN mkdir /var/log/zagreus
COPY ./docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# CMD "/home/initialize.sh"

EXPOSE 6001