FROM php:8.4-apache

# Set Timezone in PHP
RUN echo "date.timezone = Europe/Berlin" > /usr/local/etc/php/conf.d/datetime.ini

# Set Apache Document Root to Symfony Public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Git, Zip
RUN apt-get -y update
RUN apt-get -y install git zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER 1000:1000

# Startskript kopieren
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Standardbefehl überschreiben
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
