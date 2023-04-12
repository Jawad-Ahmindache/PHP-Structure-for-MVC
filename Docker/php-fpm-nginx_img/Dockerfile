FROM php:8.1.12RC1-fpm-bullseye
RUN apt update -y && apt upgrade -y
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
   && php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
   && php composer-setup.php \
   && php -r "unlink('composer-setup.php');" \
   && mv composer.phar /usr/local/bin/composer \ 
   && apt install npm -y \
   && apt install libpng-dev -y \
   && apt install libcurl4-openssl-dev -y \
   && apt install openssl -y \
   && apt install libicu-dev -y
   

#LINUX OPTIMIZE IMAGE TOOL (dependency for php library image-optimzer)
RUN apt install jpegoptim -y \
  && apt install optipng -y \
  && apt install pngquant -y \
  && npm install -g svgo@1.3.2 -y \  
  && apt install gifsicle -y \
  && apt install webp -y

#PHP EXTENSION
RUN docker-php-ext-install pdo pdo_mysql \ 
    && apt install -y libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-install gd \
    && docker-php-ext-install curl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure intl \
    && pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis






