#!/usr/bin/env bash

# Install PHP7.
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get -y update
sudo apt-get install -y git build-essential
sudo apt-get install -y php7.0 php7.0-dev php7.0-common php7.0-cli php7.0-fpm php7.0-curl php7.0-gd php7.0-mcrypt php7.0-readline php7.0-pgsql php7.0-xmlrpc php7.0-json php7.0-sqlite3 php7.0-mysql php7.0-opcache php7.0-bz2 php7.0-xml php7.0-mbstring php7.0-soap php7.0-zip php7.0-intl libapache2-mod-php7.0
sudo mkdir /var/log/www
sudo chown vagrant:vagrant /var/log/www
sudo chown vagrant:vagrant /var/lib/php/sessions


# Install Xdebug.
wget -O ~/xdebug-2.4.0rc4.tgz https://xdebug.org/files/xdebug-2.4.0rc4.tgz
tar -xvzf xdebug-2.4.0rc4.tgz
rm xdebug-2.4.0rc4.tgz
cd xdebug-2.4.0RC4/
phpize
./configure
make
sudo make install
sudo make clean
sudo phpize --clean
cd $HOME

## Add Xdebug to PHP7.
#sudo cp /vagrant/config/php/xdebug.ini /etc/php/7.0/mods-available
#sudo ln -s /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/cli/conf.d/
#sudo ln -s /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/fpm/conf.d/

# PHP config.
sudo cp /vagrant/config/php/php-cli.ini /etc/php/7.0/cli/php.ini

# Install Apache.
sudo apt-get -y install apache2
sudo cp /vagrant/config/apache/tactic.dev.conf /etc/apache2/sites-available/tactic.dev.conf
sudo a2ensite tactic.dev.conf
sudo a2enmod rewrite

# Install MySQL.
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get install -y mysql-server
sudo mysql_install_db

# mysql_secure_installation
export DATABASE_PASS=password
mysqladmin -u root -proot password "$DATABASE_PASS"
mysql -u root -p"$DATABASE_PASS" -e "UPDATE mysql.user SET Password=PASSWORD('$DATABASE_PASS') WHERE User='root'"
mysql -u root -p"$DATABASE_PASS" -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1')"
mysql -u root -p"$DATABASE_PASS" -e "DELETE FROM mysql.user WHERE User=''"
mysql -u root -p"$DATABASE_PASS" -e "FLUSH PRIVILEGES"

# Web root.
sudo chown -R vagrant:vagrant /var/www

# Install composer
php /vagrant/config/php/composer-setup.php
sudo mv composer.phar /usr/local/bin/composer

# Composer packages.
composer g require psy/psysh:@stable phpunit/phpunit

cd /var/www
git clone https://github.com/dmitri-liventsev/yourownframework.git
cd yourownframework
composer install
sudo chmod +x /var/www/yourownframework/Job/checker.php
bin/sh ./standalonescript.sh &
cd $HOME

mysql < /var/www/yourownframework/Db/dump.sql -u root --password=$DATABASE_PASS

sudo chmod -R 755 /var/www
sudo service apache2 restart

# Bash.
cp /vagrant/config/bash/profile /home/vagrant/.profile