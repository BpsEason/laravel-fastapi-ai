FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN touch /var/www/html/database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

CMD ["apache2-foreground"]

EXPOSE 80