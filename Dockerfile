# 使用 PHP 8.1 + FPM 作為 base image
FROM php:8.1-fpm

# 安裝 PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql


# 設定工作目錄
WORKDIR /var/www/MemberSystemMVC


# 複製當前目錄下的所有檔案到容器中
COPY . /var/www/MemberSystemMVC

# 設定檔案擁有權限
RUN chown -R www-data:www-data /var/www/html

# 預設啟動 php-fpm
CMD ["php-fpm"]
