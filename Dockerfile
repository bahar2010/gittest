FROM php:8.1-apache

#RUN apt-get update \
 #   && apt-get install -y nano zip unzip git libicu-dev \
  # && docker-php-ext-configure intl \
   # && docker-php-ext-install intl \
    #&& apt-get clean \
   # && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install zip intl mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && composer self-update

COPY codeigniter.conf /etc/apache2/sites-available/
RUN a2ensite codeigniter.conf \
    && service apache2 reload || true

RUN cd /etc/apache2/sites-available \
    && a2dissite 000-default.conf \
    && service apache2 reload || true
EXPOSE 80
