FROM php:7.2-apache
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update \
    && apt-get install -y \
        libjpeg-dev  \
        curl \
        sed \
        zlib1g-dev
   

# Atualizo o sistema do ubutu como instalo vim um editor texto dentro do terminal
RUN apt update && apt install -y vim
# Instalei o sqlite para usar banco para laravel criar seed e factory do curso da scholofnet api
RUN apt-get install -y sqlite3 libsqlite3-dev
#Instalando o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD config-apache/000-default.conf /etc/apache2/sites-enabled/000-default.conf


RUN a2enmod rewrite


#RUN comando estou enviando para criar pasta
RUN mkdir /var/www/api

RUN service apache2 restart
#Adicionando no grupo todos as pastas e subdiretorios
RUN chown -R www-data /var/www
#Adicionando no grupo apenas essa pasta
RUN chgrp -R www-data /var/www

VOLUME /var/www/api

# WORKDIR - Ele diz quando abrir meu container ele vai abrir nessa pasta
WORKDIR /var/www/api  
#EXPOSE estou liberando acesso ao container pelo porta 80 e 443 para SLL
EXPOSE 80
#CMD comando estou enviando para o apache ser executado em segundo plano continuo
CMD ["apache2-foreground"]
