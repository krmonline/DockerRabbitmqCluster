FROM php:fpm
RUN apt update && apt -y  install iputils-ping && apt -y  install telnet && apt -y  install net-tools && apt -y install librdkafka1
ADD www.conf /usr/local/etc/php-fpm.d/
ADD stomp.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718/
ADD rdkafka.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718/
RUN docker-php-ext-enable stomp
RUN docker-php-ext-enable rdkafka
