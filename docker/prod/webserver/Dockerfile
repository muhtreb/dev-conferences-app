# Base image
FROM php:8.5-fpm-alpine

# Install necessary packages for both PHP and Nginx
RUN apk update \
    && apk add --no-cache \
        nginx \
        vim \
        unzip \
        iputils \
        icu-dev \
        postgresql-dev \
        zlib-dev \
        libzip-dev \
        libxslt-dev \
        supervisor \
        git \
        curl \
        nodejs \
        npm \
    && rm -rf /var/cache/apk/*

# Configure PHP
COPY ./docker/prod/php-fpm/docker-www.conf /etc/php/8.5/fpm/conf.d/docker-www.conf
COPY ./docker/prod/php-fpm/php-ini-overrides.ini /etc/php/8.5/fpm/conf.d/99-overrides.ini

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) xsl

# APP_ENV is set to prod
ENV APP_ENV=prod

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove vendor directory if it exists
RUN rm -rf /application/vendor

# Optional build arg for traceability and to bust the COPY layer cache when needed.
# Pass with: docker build --build-arg GIT_SHA=$(git rev-parse HEAD)
ARG GIT_SHA=unknown
ENV BUILD_GIT_SHA=$GIT_SHA
LABEL git-sha=$GIT_SHA

# Install the composer dependencies
COPY . /application
WORKDIR /application
RUN rm -rf var/cache var/log \
    && composer install --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

# Install npm dependencies and build assets
RUN npm install && npm run build

# Build Symfony prod cache last, against the exact templates and built assets
# that will ship in this image. Doing it here (after every COPY/RUN that can
# influence templates or services) avoids stale compiled Twig from earlier layers.
# Then hand var/ over to www-data so PHP-FPM can write runtime caches
# (the bazinga JS translation bundle, profiler stub, etc.) at request time.
RUN rm -rf var/cache/prod \
    && php bin/console cache:clear --env=prod --no-warmup \
    && php bin/console cache:warmup --env=prod \
    && echo "$GIT_SHA" > public/build/.git-sha \
    && chown -R www-data:www-data var/cache var/log

# Run database migrations
RUN php bin/console --no-interaction doctrine:migrations:migrate || true

# Set up Nginx
COPY ./docker/prod/nginx/nginx-main.conf /etc/nginx/nginx.conf
COPY ./docker/prod/nginx/site.conf /etc/nginx/conf.d/default.conf

# Configure Supervisor
COPY ./docker/prod/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

# Expose ports for Nginx and PHP-FPM
EXPOSE 8080

# Start Supervisord to manage both services
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]