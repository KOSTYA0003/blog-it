FROM php:8.2-fpm

# 1. Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# 2. Установка Node.js (исправленная ссылка)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 3. Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 5. Копируем файлы проекта
COPY . .

# 6. Установка PHP и JS зависимостей
RUN composer install --no-interaction --optimize-autoloader
RUN npm install --force && npm run build

# 7. Настройка прав доступа
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]