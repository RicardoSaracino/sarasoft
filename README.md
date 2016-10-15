http://symfony.com/doc/current/validation/translations.html
------
http://elnur.pro/how-to-add-or-update-several-model-objects-at-once-with-a-single-form-in-symfony
http://elnur.pro/use-only-infrastructural-bundles-in-symfony
-----
http://symfony.com/doc/current/security/csrf_in_login_form.html
$ php bin/console doctrine:mapping:import --force AcmeBlogBundle xml
-----
http://symfony.com/doc/current/templating.html#embedding-controllers

app/Resources/views/
The application's views directory can contain application-wide base templates (i.e. your application's layouts and templates of the application bundle) as well as templates that override third party bundle templates (see How to Override Templates from Third-Party Bundles).
vendor/path/to/CoolBundle/Resources/views/
Each third party bundle houses its templates in its Resources/views/ directory (and subdirectories). When you plan to share your bundle, you should put the templates in the bundle instead of the app/ directory.
---

https://github.com/symfony/symfony/issues/12808
http://stackoverflow.com/questions/39641809/symfony-convert-to-users-timezone-in-controller-or-twig
http://stackoverflow.com/questions/9990625/symfony2-inject-current-user-in-service
http://stackoverflow.com/questions/10694315/symfony2-where-to-set-a-user-defined-time-zone

-----

http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/install-LAMP.html

[ec2-user ~]$ sudo usermod -a -G www ec2-user

[ec2-user ~]$ exit

-----

git clone

git pull

-----

rm -rf var/cache/*;
rm -rf var/logs/*;
rm -rf var/session/*;

find * -type f -exec chmod 660 {} \;
find * -type d -exec chmod 770 {} \;

chgrp -R apache *;
chown -R apache *;

php bin/console cache:clear; 
php bin/console cache:clear --env=prod;

-----

http://bryanlor.com/blog/symfony2-troubleshooting-runtimeexception-unable-create-cache-directory

setfacl -R -m u:apache:rwX -m u:ec2-user:rwX var/cache var/logs var/sessions;
setfacl -dR -m u:apache:rwx -m u:ec2-user:rwx var/cache var/logs var/sessions;

-----

CREATE DATABASE IF NOT EXISTS `sarasoft` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sarasoft`;

php bin/console doctrine:schema:update --dump-sql | mysql -p5ar4SoF7 sarasoft

-----

Generate

php bin/console doctrine:mapping:import --force AppBundle xml

php bin/console doctrine:mapping:convert annotation ./src

php bin/console doctrine:schema:update --dump-sql

php bin/console generate:doctrine:form AppBundle:Address

php bin/console generate:doctrine:crud --entity=AppBundle:Customer --format=annotation



[ec2-user@ip-172-31-61-162 sarasoft]$ cat /etc/httpd/conf.d/vhosts.symfony.conf
<VirtualHost *:80>

    ServerName sarasoft.site
    ServerAlias ec2-52-55-71-226.compute-1.amazonaws.com www.sarasoft.site

    DocumentRoot /var/www/sarasoft/web

    <Directory /var/www/sarasoft/web>
        #Require all granted


        AllowOverride None
        Order Allow,Deny
        Allow from All

        #<IfModule mod_rewrite.c>
        #    Options -MultiViews
        #    RewriteEngine On
        #    RewriteCond %{REQUEST_FILENAME} !-f
        #    RewriteRule ^(.*)$ app.php [QSA,L]
        #</IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/sarasoft/web>
    #     Options FollowSymlinks
    # </Directory>

    # optionally disable the RewriteEngine for the asset directories
    # which will allow apache to simply reply with a 404 when files are
    # not found instead of passing the request into the full symfony stack
    #<Directory/var/www/sarasoft/web/bundles>
    #    <IfModule mod_rewrite.c>
    #        RewriteEngine Off
    #    </IfModule>
    #</Directory>

    ErrorLog /var/log/httpd/sarasoft_error.log
    CustomLog /var/log/httpd/sarasoft_access.log combined

    php_flag log_errors on
    php_flag display_errors on
    php_value error_reporting 32767
    php_value error_log /var/www/sarasoft/php_error.log
    php_value date.timezone "UTC"
</VirtualHost>
