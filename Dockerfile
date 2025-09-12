# Use the official PHP 8.2 with Apache image
FROM php:8.2-apache

# Enable mysqli extension (common for MySQL database use)
RUN docker-php-ext-install mysqli

# Copy your project files into Apache web root
COPY . /var/www/html/

# Expose Apache port
EXPOSE 80

# Start Apache when container runs
CMD ["apache2-foreground"]
