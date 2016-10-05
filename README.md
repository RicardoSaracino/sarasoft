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



http://symfony.com/doc/current/security/entity_provider.html
