# Use the official PHP image with Apache
FROM php:8.1-apache

# Install SQLite and necessary PHP extensions
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev && docker-php-ext-install pdo pdo_sqlite

# Set up environment variables
# Copy the project files into the container
COPY . /var/www/html/

# Set working directory to the project folder
WORKDIR /var/www/html/

# Set appropriate permissions for the copied files
RUN chmod -R 777 /var/www/html/

# Expose port 80 for Apache to listen on
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
