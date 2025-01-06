# Use an official PHP image with Apache
FROM php:8.1-apache

# Copy all website files to the Apache web directory
COPY . /var/www/html/

# Set permissions for the web directory
RUN chown -R www-data:www-data /var/www/html/ && \
    chmod -R 755 /var/www/html/

# Install PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80 for HTTP traffic
EXPOSE 80

# Enable Apache mod_rewrite if required (e.g., for .htaccess)
RUN a2enmod rewrite

# Start the Apache server
CMD ["apache2-foreground"]
