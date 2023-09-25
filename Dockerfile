FROM php:8.0-apache


# Copy the project files to the container
COPY . /var/www/html

# Set the document root
WORKDIR /var/www/html

# Install dependencies and enable necessary Apache modules
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug 


# Expose port 80 for Apache
EXPOSE 80

# Start Apache 

CMD ["apache2-foreground"]