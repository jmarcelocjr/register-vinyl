FROM php:7.0-fpm

RUN apt-get update \
	&& docker-php-ext-install pdo pdo_mysql

RUN echo "allow_url_fopen = On" > /usr/local/etc/php/conf.d/allow_url_fopen.ini
RUN echo "upload_max_filesize = 20M\npost_max_size = 64M\n" > /usr/local/etc/php/conf.d/upload_max_size.ini