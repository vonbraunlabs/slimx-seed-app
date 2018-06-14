FROM vonbraunlabs/php:7.2-apache-composer-redis-extended

RUN apt-get install -y mysql-client

COPY composer.json ./
COPY composer.lock ./
RUN composer -vvv -o install
RUN a2enmod headers

COPY ports.conf /etc/apache2/
COPY 000-default.conf /etc/apache2/sites-enabled/
COPY index.php ./
COPY config/application.php.template ./config/application.php
COPY src ./src/

EXPOSE 8085
