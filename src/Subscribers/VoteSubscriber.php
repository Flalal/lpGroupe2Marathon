<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 20:30
 */

namespace App\Subscribers;


use App\AppEvent;
use App\Entity\Vote;
use App\Event\VoteEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VoteSubscriber implements EventSubscriberInterface
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
            AppEvent::VOTE_ADD => 'voteAdd',
        );
    }

    public function voteAdd(VoteEvent $voteEvent){
        $vote = $voteEvent->getVote();
        /** @var Vote $vote */
        $vote->setUser($this->token->getToken()->getUser());
        $vote->setRecipe($voteEvent->getRecette());
        $this->em->persist($vote);
        $this->em->flush();
    }


}