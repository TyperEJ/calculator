FROM php:8.2-alpine

###########################################
# Composer
###########################################

RUN \
       curl -sfL https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
       chmod +x /usr/bin/composer                                                                     && \
       composer self-update --clean-backups 2.3.10

###########################################
# Laravel install
###########################################

WORKDIR "/var/www"

COPY . .

RUN cp .env.example .env

RUN composer install --no-interaction --optimize-autoloader

ENTRYPOINT ["php", "artisan"]
