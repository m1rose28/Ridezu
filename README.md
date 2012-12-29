ridezu README
=============

Folders:

    iphone/	ridezu iPhone app
    html/	web front
    playground/	test apps.

***
Git Commands
------------

 git config --global user.name "txie"
 git config --global user.email "txie2004@gmail.com"
 git config -l
 git init
 git add README.md
 git commit -m "1st commit"
 git remote add origin git@github.com:m1rose28/ridezu.git
 git push -u origin master

Installing on a local machine (localhost is assumed name), this was done on a macbook, but linux should be approximately the same
install macports
install apache2

sudo port install mysql
  if  the build fails cd into the build directory and run ./configure then sudo make install

start mysql
sudo safe_mysqld &
  you may need to run mysql_install_db to get things going, this will be in /usr/local/bin

sudo mysql < mysql.dump  # where mysql.dump   is a dump from some machine

sudo mysql 
> grant all privileges on ridezu.* to ridezu@localhost identified by 'ridezu123';

install the html from git in /var/html
change DocumentRoot in /etc/apache2/httpd.conf to '/var/html'
sudo apachectl restart
sudo chown -R youruser /var/html  # this makes editing easier

you should now have a running ridezu server at http://localhost/index.php
