<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $recettes = $em->getRepository(Recipe::class)->findAll();
        $articles = $em->getRepository(Article::class)->findAll();
        //$articles = $em->createQuery("select a from \App\Entity\Article a join a.user")->getResult();
        return $this->render('welcome/welcome.html.twig',['recettes'=>$recettes,'articles'=>$articles]);
    }
}
