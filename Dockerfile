FROM php:7-apache

ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_ROOT_USER=root

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY start-apache /usr/local/bin
RUN a2enmod rewrite

COPY src /var/www/
RUN chown -R www-data:www-data /var/www

CMD ["start-apache"]