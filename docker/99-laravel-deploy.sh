#!/bin/sh
set -e

# Если используется SQLite и база данных лежит в монтируемой директории, убедимся что она существует
if [ "$DB_CONNECTION" = "sqlite" ]; then
    DB_DIR=$(dirname "$DB_DATABASE")
    if [ ! -d "$DB_DIR" ]; then
        echo "Создаем директорию для базы данных: $DB_DIR"
        mkdir -p "$DB_DIR"
    fi
    if [ ! -f "$DB_DATABASE" ]; then
        echo "Создаем файл базы данных: $DB_DATABASE"
        touch "$DB_DATABASE"
    fi
fi

# Выполняем миграции
echo "Запускаем миграции базы данных..."
php artisan migrate --force

# Запускаем сидеры (они безопасны и наполнят только пустые таблицы стоических цитат)
echo "Запускаем сидеры базы данных..."
php artisan db:seed --force

# Оптимизируем кэш Laravel для максимальной скорости работы в продакшене
echo "Оптимизируем кэш приложения..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
