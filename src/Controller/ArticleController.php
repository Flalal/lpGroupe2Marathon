<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/edit", name="app_article_edit")
     */
    public function edit(Request $request, EventDispatcher $eventDispatcher, Article $article)
    {
        $article = $this->getDoctrine()->getManager()->getRepository(Article::class)->find($article->getId());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $userCardEvent = $this->get(ArticleEvent::class);
            $userCardEvent->setUserCard($article);

            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::EDIT, $userCardEvent);


            return $this->redirectToRoute('home_index');
        }
        return $this->render("UserCard/add.html.twig", ['form' => $form->createView(),]);

    }
}
