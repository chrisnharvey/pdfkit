FROM composer AS composer

COPY . /app

RUN composer install --ignore-platform-reqs

FROM php:7.4-cli-buster
COPY --from=composer /app /pdfkit

RUN cd /tmp && \
    apt-get update && \
    apt-get install -qq libffi-dev && \
    docker-php-ext-install ffi && \
    curl -LO https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.buster_amd64.deb && \
    apt-get install -qq ./wkhtmltox_0.12.6-1.buster_amd64.deb

WORKDIR /pdfkit