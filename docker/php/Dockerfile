# イメージを取得
FROM php:8.2-fpm
# 独自のphp.iniファイル(PHPの設定ファイル)を 
# コンテナ内の/usr/local/etc/php/ディレクトリにコピー
COPY php.ini /usr/local/etc/php/

RUN pecl install redis && docker-php-ext-enable redis

# パッケージやPHPの拡張モジュールをインストールするコマンド　を実行
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql bcmath opcache

# composer をインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 作業ディレクトリを/var/wwwに設定
WORKDIR /var/www/html
