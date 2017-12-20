<?php

namespace App\Subscribers;

use App\Entity\Article;
use App\Event\ArticleEvent;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\AppEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArticleSubscriber implements EventSubscriberInterface
{
    private $em;
    private $token;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        $this->em = $em;
        $this->token = $tokenStorage;
    }


    public static function getSubscribedEvents()
    {
        return [
          AppEvent::EDIT_ARTICLE => 'edit',
          AppEvent::CREATE_ARTICLE => 'create',
          AppEvent::DELETE_ARTICLE => 'delete',
        ];

    }

    public function create(ArticleEvent $articleEvent){

        $article = $articleEvent->getArticle();
        /** @var Article $article */
        $user = $this->token->getToken()->getUser();
        $article->setUser($user);
        $this->em->persist($article);
        $this->em->flush();
    }
    public function edit(ArticleEvent $articleEvent){
        $article = $articleEvent->getArticle();
        /** @var Article $article */
        $article->setUpdatedAt(new DateTime());
        $this->em->persist($article);
        $this->em->flush();

    }
    public function delete(ArticleEvent $articleEvent){
        $article = $articleEvent->getArticle();
        $this->em->remove($article);

    }

}