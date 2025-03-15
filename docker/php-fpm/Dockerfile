FROM php:8.3-fpm AS base

ENV COMPOSER_ALLOW_SUPERUSER=1

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    gettext \
    libicu-dev \
    locales \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* \

RUN set -eux; \
	install-php-extensions \
		@composer \
		apcu \
		intl \
        pdo_pgsql \
        pgsql \
        opcache \
        intl \
		zip \
        bcmath \
        soap \
	    yaml;

WORKDIR /var/www

COPY ./composer.json .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Stage: Production
FROM php:8.3-fpm AS production

ENV APP_ENV=prod

ENV APP_DEBUG=0

COPY --from=base /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=base /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=base /usr/local/bin/docker-php-ext-* /usr/local/bin/

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=builder /var/www /var/www

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

USER www-data

RUN php bin/console cache:clear

EXPOSE 9000

CMD ["php-fpm"]