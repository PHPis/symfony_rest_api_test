FROM php:8-fpm

COPY ./ /var/www/symfony
WORKDIR /var/www/symfony

RUN apt-get update -y \
    && apt-get install -y \
        zip \
        git \
        curl \
    && docker-php-ext-install \
        mysqli \
        pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 9000

CMD ["php-fpm"]
