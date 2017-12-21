<?php

namespace App\Subscribers;

use App\Entity\Recipe;
use App\AppEvent;
use App\Event\RecetteEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RecetteSubscribers implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AppEvent::RECETTE_ADD => 'recetteAdd',
            AppEvent::RECETTE_EDIT => 'recetteEdit',
        );
    }

    public function recetteAdd(RecetteEvent $recetteEvent)
    {
        $recette = $recetteEvent->getRecette();
        /** @var Recipe $recette */
        $recette->setCreatedAt(new \DateTime("now"));
        $recette->setUpdatedAt(new \DateTime("now"));
        $this->em->persist($recette);
        $this->em->flush();
    }

    public function recetteEdit(RecetteEvent $recetteEvent){
        $recette = $recetteEvent->getRecette();
        /** @var Recipe $recette */
        $recette->setUpdatedAt(new \DateTime("now"));
        $this->em->persist($recette);
        $this->em->flush();
    }

    public function recetteDelete(RecetteEvent $recetteEvent){
        $recette = $recetteEvent->getRecette();


        //Delete vote et comments
        $this->em->remove($recette);
        $this->em->flush();
    }

}