# Use the official PHP image with Apache as the base image
FROM php:8.0

# Install Apache and utilities
RUN apt-get update \
    && apt-get install -y apache2 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
#RUN a2enmod rewrite \
 #   && a2enmod headers

# Set working directory
WORKDIR /var/www/html

# Copy the contents of your project into the container
COPY signupValidate.js /var/www/html
COPY style.css /var/www/html
COPY ./assets /var/www/html
COPY signup.html /var/www/html
COPY login.html /var/www/html
COPY . .

# Expose port 80 (default port for Apache)
EXPOSE 80

# Configure Apache
RUN echo "<Directory /var/www/html/>" >> /etc/apache2/apache2.conf \
    && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "    AddType application/x-httpd-php .php" >> /etc/apache2/apache2.conf \
    && echo "    AddHandler application/x-httpd-php .php" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Start Apache in the foreground when the container starts
CMD ["apache2ctl", "-D", "FOREGROUND"]
