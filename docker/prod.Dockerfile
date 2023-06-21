FROM php:8.1-apache

COPY . /app

WORKDIR /app

RUN groupadd -g 1000 app
RUN useradd -u 1000 -ms /bin/bash -g app app

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y git zip unzip libcurl4-openssl-dev pkg-config libssl-dev


RUN pecl install mongodb \
    && docker-php-ext-enable mongodb


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN php artisan key:generate

USER app


COPY ./docker/apache2.conf /etc/apache2/sites-available/000-default.conf


RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]