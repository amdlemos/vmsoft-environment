# Utilizando CentOS 7 como base (última versão estável antes da descontinuação)
FROM centos:7

# Configurar repositórios alternativos para CentOS
RUN sed -i 's/mirrorlist/#mirrorlist/g' /etc/yum.repos.d/CentOS-* && \
    sed -i 's|#baseurl=http://mirror.centos.org|baseurl=http://vault.centos.org|g' /etc/yum.repos.d/CentOS-*

# Instalar repositório EPEL
RUN yum -y install epel-release && \
    yum -y update

# Instalar repositório Remi (necessário para PHP 7.4)
RUN yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm

# Instalar yum-utils para gerenciar repositórios
RUN yum -y install yum-utils

# Habilitar o repositório Remi PHP 7.4
RUN yum-config-manager --enable remi-php74

# Instalar Apache e ferramentas essenciais
RUN yum -y install httpd httpd-tools wget unzip gcc make zlib-devel bzip2-devel openssl-devel ncurses-devel sqlite-devel readline-devel tk-devel gdbm-devel libffi-devel xz-devel

# Instalar PHP 7.4 e todas as extensões necessárias 
RUN yum -y install php php-cli php-fpm php-common \
    php-bcmath php-bz2 php-calendar php-ctype php-curl php-dba \
    php-dom php-enchant php-exif php-fileinfo php-ftp php-gd \
    php-gettext php-gmp php-iconv php-imap php-intl php-json \
    php-ldap php-mbstring php-mysqlnd php-odbc php-pdo \
    php-pgsql php-phar php-posix php-pspell php-shmop \
    php-simplexml php-snmp php-soap php-sockets php-sodium \
    php-sqlite3 php-sysvmsg php-sysvsem php-sysvshm php-tidy \
    php-tokenizer php-xml php-xmlwriter php-xsl php-zip \
    php-mcrypt php-mysqli php-pdo_mysql php-pdo_odbc \
    php-pdo_pgsql php-pdo_sqlite php-xmlreader php-xmlrpc \
    php-apcu php-igbinary php-imagick php-msgpack php-memcached php-redis php-opcache

# Instalar xdebug e outras extensões
RUN yum -y install php-pecl-xdebug

# Instalar IonCube Loader
RUN mkdir -p /tmp/ioncube && \
    cd /tmp/ioncube && \
    wget https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz && \
    tar xzf ioncube_loaders_lin_x86-64.tar.gz && \
    cp ioncube/ioncube_loader_lin_7.4.so /usr/lib64/php/modules/ && \
    echo "zend_extension = /usr/lib64/php/modules/ioncube_loader_lin_7.4.so" > /etc/php.d/01-ioncube_loader.ini && \
    cd / && rm -rf /tmp/ioncube

# Configurar PHP para usar o PostgreSQL
RUN echo "extension=pgsql.so" > /etc/php.d/20-pgsql.ini && \
    echo "extension=pdo_pgsql.so" > /etc/php.d/30-pdo_pgsql.ini

# Configurar Apache 
RUN sed -i 's/Listen 80/Listen 8080/' /etc/httpd/conf/httpd.conf && \
    sed -i 's/User apache/User www-data/' /etc/httpd/conf/httpd.conf && \
    sed -i 's/Group apache/Group www-data/' /etc/httpd/conf/httpd.conf && \
    echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf && \
    mkdir -p /var/www/html && \
    chown -R root:root /var/www/html && \
    echo "<?php phpinfo(); ?>" > /var/www/html/info.php

# Adicionar usuário para o Apache
RUN useradd -ms /bin/bash www-data

# Limpar cache do yum para reduzir o tamanho da imagem
RUN yum clean all && rm -rf /var/cache/yum

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Expor porta do Apache
EXPOSE 8080

# Criar script de inicialização
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'exec httpd -D FOREGROUND' >> /start.sh && \
    chmod +x /start.sh

# Comando padrão ao iniciar o container
CMD ["/start.sh"]







# # Habilitar o repositório Remi PHP 7.4
# RUN yum-config-manager --enable remi-php74
#
# # Instalar PHP 7.4 e extensões comuns
# RUN yum -y install php php-cli php-fpm php-mysqlnd php-zip php-devel php-gd php-mcrypt php-mbstring php-curl php-xml php-pear php-bcmath php-json php-intl php-opcache
#
# # Limpar cache do yum para reduzir o tamanho da imagem
# RUN yum clean all && rm -rf /var/cache/yum
#
# # Verificar versão do PHP instalada
# RUN php -v
#
# # Configurar diretório de trabalho
# WORKDIR /var/www/html
#
# # Porta padrão do PHP-FPM
# EXPOSE 9000
#
# # Comando padrão ao iniciar o container
# CMD ["php", "-a"]
