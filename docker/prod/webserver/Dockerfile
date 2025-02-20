FROM jkaninda/nginx-php-fpm:8.3

COPY . /var/www/html

VOLUME /var/www/html/storage

WORKDIR /var/www/html

# install xsl extension
RUN apt-get update && apt-get install -y libxslt-dev && docker-php-ext-install xsl

RUN composer install

RUN chown -R www-data:www-data /var/www/html

USER www-data