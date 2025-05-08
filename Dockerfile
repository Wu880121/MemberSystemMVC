# 使用 PHP 8.1 + FPM 基礎映像
FROM php:8.1-fpm

# 安裝 PDO MySQL Extension
RUN docker-php-ext-install pdo pdo_mysql

# 設定容器內的工作目錄
WORKDIR /var/www/html

# 複製所有程式碼進工作目錄（包括 app、public、routes、.env 等）
COPY . /var/www/html

# 設定檔案擁有權（給 www-data 使用）
RUN chown -R www-data:www-data /var/www/html

# 預設啟動 php-fpm
CMD ["php-fpm"]
