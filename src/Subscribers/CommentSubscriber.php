<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 17:37
 */

namespace App\Subscribers;


use App\AppEvent;
use App\Entity\Comment;
use App\Entity\Recipe;
use App\Event\CommentEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentSubscriber implements EventSubscriberInterface
{
    private $em;
    private $token;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->token = $token;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AppEvent::COMMENT_ADD => 'commentAdd',
            AppEvent::COMMENT_EDIT => 'commentEdit',
        );
    }

    public function commentAdd(CommentEvent $commentEvent){

        $comment = $commentEvent->getComment();
        /** @var Comment $comment */
        $comment->setCreatedAt(new \DateTime("now"));
        $comment->setUpdatedAt(new \DateTime("now"));
        $comment->setRecipe($commentEvent->getRecette());
        $comment->setUser($this->token->getToken()->getUser());
        $this->em->persist($comment);
        $this->em->flush();
    }

    public function commentEdit(CommentEvent $commentEvent){

        $comment = $commentEvent->getComment();
        /** @var Comment $comment */
        $comment->setUpdatedAt(new \DateTime("now"));
        $this->em->persist($comment);
        $this->em->flush();
    }

}