FROM php:8.2-fpm AS backend

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl opcache

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies (no scripts yet)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application code
COPY . .

# Generate autoloader
RUN composer dump-autoload --optimize --no-dev

# -----------------------------------------------------------------------------
# Frontend Build Stage
# -----------------------------------------------------------------------------
FROM node:20 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# -----------------------------------------------------------------------------
# Final Stage
# -----------------------------------------------------------------------------
FROM php:8.2-fpm

# Install runtime dependencies (Nginx)
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions again (or copy from backend? Copying is harder for extensions usually, easier to reinstall or use one base)
# To save time/layers, we re-install. 
RUN docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd zip intl opcache
RUN pecl install redis && docker-php-ext-enable redis

WORKDIR /var/www/html

# Copy built backend assets
COPY --from=backend /var/www/html /var/www/html

# Copy built frontend assets
COPY --from=frontend /app/public/build /var/www/html/public/build

# Copy Nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy Start Script
COPY scripts/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
