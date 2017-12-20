<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class RecetteEvent extends Event
{
    private $recette;

    /**
     * @return mixed
     */
    public function getRecette()
    {
        return $this->recette;
    }

    /**
     * @param mixed $recette
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;
    }




}