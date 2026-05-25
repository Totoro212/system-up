# Шаг 1: Сборка фронтенд-ресурсов (Vite / Tailwind / Alpine.js)
FROM node:20-alpine AS assets-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Шаг 2: Создание основного продакшен-образа PHP + Nginx
FROM serversideup/php:8.4-fpm-nginx AS runner

# Временно переключаемся на root, чтобы установить zip/unzip и скопировать скрипт развертывания
USER root
RUN apt-get update && apt-get install -y unzip git && rm -rf /var/lib/apt/lists/*

# Копируем наш кастомный deploy скрипт в системную папку автозапуска контейнера
COPY --chmod=755 docker/99-laravel-deploy.sh /etc/entrypoint.d/99-laravel-deploy.sh

# Возвращаемся в контекст безопасного пользователя www-data
USER www-data

# Указываем корневую папку для Nginx
ENV AUTOCONF_DOCUMENT_ROOT=/var/www/html/public
ENV PHP_OPCACHE_ENABLE=1

# Копируем исходный код проекта
COPY --chown=www-data:www-data . /var/www/html

# Копируем скомпилированные ассеты из Шага 1
COPY --from=assets-builder --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Устанавливаем PHP зависимости через Composer для продакшена (без dev-зависимостей)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Открываем порт 8080
EXPOSE 8080
