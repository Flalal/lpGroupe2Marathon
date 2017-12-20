<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/show", name="app_article_show")
     */
    public function show()
    {
        $em = $this->getDoctrine()->getManager();
        //$articles = $em->createQuery("select a from \App\Entity\Article a join a.user")->getResult();
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render('article/show.html.twig',['articles'=>$articles]);
    }


}
