#!/bin/bash
############################################################
# Let us Setup Apache2 for Ubuntu 16.04 with Php 7 and MySQL
############################################################

# Add PHP 7.0 Repository
sudo add-apt-repository -y ppa:ondrej/php

# Install PHP 7.0 and apache2
sudo apt-get update
sudo apt-get install -y apache2 php7.0 libapache2-mod-php7.0 php7.0-fpm php7.0-mysql

# Copy our virtual host template to sites-enabled overwriting the default site conf
sudo cp tests/_data/defaultsite.tpl /etc/apache2/sites-available/000-default.conf

# Enable mod rewrite module
sudo a2enmod rewrite
sudo a2enmod proxy_fcgi setenvif
sudo a2enconf php7.0-fpm

# Set ServerName Globally
sudo cp tests/_data/servername.tpl /etc/apache2/conf-available/servername.conf

sudo a2enconf servername

# Restart PHP
sudo service php7.0-fpm restart

# Restart apache
sudo service apache2 restart