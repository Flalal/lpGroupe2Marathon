<?php

namespace App\Vote;

use App\Entity\Recipe;
use App\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;

class calculeVote
{
    private $em;

    /**
     * calculeVote constructor.
     * @param $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }


    public function moyenVote( Recipe $recette){
        $votes = $this->em->getRepository(Vote::class)->findBy(['recipe'=>$recette]);
        $somme = 0;
        foreach ($votes as $vote){
            $somme+= $vote->getValue();
        }
        return round($somme/count($votes),2);

    }
}