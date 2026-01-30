FROM php:8.2-cli

# Install MySQL drivers
RUN docker-php-ext-install pdo pdo_mysql mysqli

WORKDIR /app
COPY . .

# Railway injects PORT at runtime
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t public"]
