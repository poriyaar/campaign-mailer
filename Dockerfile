FROM dunglas/frankenphp:1-php8.4-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
    pdo_pgsql \
    pdo_sqlite \
    redis \
    pcntl \
    posix \
    mbstring \
    intl \
    bcmath \
    zip \
    opcache

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
