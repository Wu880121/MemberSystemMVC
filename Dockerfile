# 使用 PHP 8.1 + FPM
FROM php:8.1-fpm

# 安裝 PDO MySQL Extension
RUN docker-php-ext-install pdo pdo_mysql

# 設定工作目錄
WORKDIR /var/www/html

# 複製檔案
COPY . .

# 設定權限
RUN chown -R www-data:www-data /var/www/html

# 啟動 php-fpm
CMD ["php-fpm"]
