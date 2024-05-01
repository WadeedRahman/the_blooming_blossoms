# Use the official PHP image as the base image
FROM php:latest

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy the contents of your project into the container
COPY . .

# Expose port 80 (default port for Apache)
EXPOSE 80
