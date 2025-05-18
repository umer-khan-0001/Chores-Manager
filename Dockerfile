# Use official PHP image with Apache
FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Copy application code into the container
COPY task_manager_ci/ /var/www/html/

# Set permissions (optional, but helps avoid permission issues)
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80
