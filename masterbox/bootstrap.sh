#!/bin/bash
sudo mv /etc/apt/sources.list.d/ondrej-php5-5_6-trusty.list /etc/apt/sources.list.d/ondrej-php5-5_6-trusty.list.bak
sudo apt-get update
sudo apt-get -y install libapache2-mod-php7.0 libphp7.0-embed libssl-dev openssl php7.0-cgi php7.0-cli php7.0-common php7.0-dev php7.0-fpm php7.0-phpdbg php7.0-xml
sudo service apache2 restart

mysql -e "create user master identified by 'K1ir5v2tNVhrmyHz';"
mysql -e "create database master character set utf8 collate utf8_general_ci;"
mysql -e "grant all privileges on master.* to master@localhost identified by 'K1ir5v2tNVhrmyHz';flush privileges;"

mysqldump -u master -pK1ir5v2tNVhrmyHz master < /var/www/master.sql
