sarasoft
========

A Symfony project created on October 5, 2016, 12:42 am.



By default the EntityManager returns a default implementation of Doctrine\ORM\EntityRepository when you call EntityManager#getRepository($entityClass). You can overwrite this behaviour by specifying the class name of your own Entity Repository in the Annotation, XML or YAML metadata. In large applications that require lots of specialized DQL queries using a custom repository is one recommended way of grouping these queries in a central location.

<?php
namespace MyDomain\Model;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MyDomain\Model\UserRepository")
 */
class User
{

}

class UserRepository extends EntityRepository
{
    public function getAllAdminUsers()
    {
        return $this->_em->createQuery('SELECT u FROM MyDomain\Model\User u WHERE u.status = "admin"')
                         ->getResult();
    }
}
You can access your repository now by calling:

<?php
// $em instanceof EntityManager

$admins = $em->getRepository('MyDomain\Model\User')->getAllAdminUsers();


=================

http://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/blog")
 * @Cache(expires="tomorrow")
 */
class AnnotController extends Controller
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        $posts = ...;

        return array('posts' => $posts);
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     * @ParamConverter("post", class="SensioBlogBundle:Post")
     * @Template("SensioBlogBundle:Annot:show.html.twig", vars={"post"})
     * @Cache(smaxage="15", lastmodified="post.getUpdatedAt()", etag="'Post' ~ post.getId() ~ post.getUpdatedAt()")
     * @Security("has_role('ROLE_ADMIN') and is_granted('POST_SHOW', post)")
     */
    public function showAction(Post $post)
    {
    }




    /**
     * @Route("/blog/{post_id}")
     * @Entity("post", expr="repository.find(post_id)")
     */
    public function showAction(Post $post)
    {
    }

}



http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_doctrine_crud.html

http://symfony.com/doc/current/security/form_login.html
http://symfony.com/doc/current/security/entity_provider.html
http://symfony.com/doc/current/security/access_control.html
http://symfony.com/doc/current/security/security_checker.html




<VirtualHost *:80>

    ServerName sarasoft.site
    ServerAlias ec2-52-55-71-226.compute-1.amazonaws.com

    DocumentRoot /var/www/sarasoft/web

    <Directory /var/www/sarasoft/web>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
        </IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/sarasoft/web>
    #     Options FollowSymlinks
    # </Directory>

    # optionally disable the RewriteEngine for the asset directories
    # which will allow apache to simply reply with a 404 when files are
    # not found instead of passing the request into the full symfony stack
    <Directory/var/www/sarasoft/web/bundles>
        <IfModule mod_rewrite.c>
            RewriteEngine Off
        </IfModule>
    </Directory>

    ErrorLog /var/log/httpd/sarasoft_error.log
    CustomLog /var/log/httpd/sarasoft_access.log combined
</VirtualHost>


    AllowOverride None
    Order Allow,Deny
    Allow from All
<VirtualHost *:80>

    ServerName default:80

    # ServerName ec2-52-55-71-226.compute-1.amazonaws.com:80
    # ServerAlias sarasoft.site

        DocumentRoot /var/www/sarasoft/web

    php_flag log_errors on
    php_flag display_errors on
    php_value error_reporting "E_ALL"
    #php_value error_log /var/www/sarasoft/php_error.log
    php_value date.timezone "UTC"

        <Directory /var/www/sarasoft/web>
                Require all granted
        </Directory>

        ErrorLog /var/log/httpd/sarasoft_error.log
        CustomLog /var/log/httpd/sarasoft_access.log combined
</VirtualHost>
