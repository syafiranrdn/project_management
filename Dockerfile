FROM php:8.2-apache

# Install MySQL drivers
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite (important for /api)
RUN a2enmod rewrite

# Set Apache to listen on Railway PORT
ENV PORT=8080
RUN sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Project files
WORKDIR /var/www/html
COPY . .

EXPOSE 8080
