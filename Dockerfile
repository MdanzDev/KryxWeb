FROM php:8.1-apache

# Install SQLite
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev && docker-php-ext-install pdo pdo_sqlite

# Set up environment variables
COPY . /var/www/html/
WORKDIR /var/www/html/
RUN chmod -R 777 /var/www/html/

EXPOSE 80
CMD ["apache2-foreground"]
