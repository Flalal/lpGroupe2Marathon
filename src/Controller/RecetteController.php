<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 13:07
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Recipe;
use App\AppEvent;
use App\Entity\Vote;
use App\Event\CommentEvent;
use App\Event\RecetteEvent;
use App\Event\VoteEvent;
use App\Form\CommentType;
use App\Form\RecetteType;
use App\Form\VoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecetteController
 * @package App\Controller
 * @Route(path="/recettes")
 */
class RecetteController extends Controller
{
    /**
     * @Route("/show/{option}", name="app_recette_show", defaults={"option"="id"})
     */
    public function showRecette(Request $request, $option){
        $em = $this->getDoctrine()->getManager();
        $recettes = $em->getRepository(Recipe::class)->findAll();
        if($option == "note"){
            $requete = $em->createQuery("SELECT r, avg(v.value) AS moyenne FROM App\Entity\Recipe r JOIN r.votes v GROUP BY r.id ORDER BY moyenne DESC");
            $moyenne = $requete->getResult();
            $recettes =[];
            $lesMoyennes = [];
            foreach ($moyenne as $elt) {
                $recettes[] = $elt[0];
                $lesMoyennes[$elt[0]->getId()] = $elt['moyenne'];
            }
            return $this->render('recette/show.html.twig',[
                'recettes'=>$recettes,
                'moyennes' => $lesMoyennes,
            ]);
        }
        if($option == "comments"){
            $requete = $em->createQuery("SELECT r, count(c.id) AS nbComment FROM App\Entity\Recipe r JOIN r.comments c GROUP BY r.id ORDER BY nbComment DESC");
            $nbComments = $requete->getResult();
            $recettes =[];
            $lesComments = [];
            foreach ($nbComments as $elt) {
                $recettes[] = $elt[0];
                $lesComments[$elt[0]->getId()] = $elt['nbComment'];
            }
            return $this->render('recette/show.html.twig',[
                'recettes'=>$recettes,
                'nbComments' => $lesComments,
            ]);
        }

        if($option == "decroissant"){
            $recettes = $em->getRepository(Recipe::class)->findBy([],['id'=>'DESC']);
        }
        return $this->render('recette/show.html.twig',[
            'recettes'=>$recettes,
        ]);
    }

    /**
     * @Route("/add" , name="app_recette_add")
     */
    public function addRecette(Request $request){
        $recette = $this->get(Recipe::class);
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $recetteEvent = $this->get(RecetteEvent::class);
            /** @var RecetteEvent $recetteEvent */
            $recetteEvent->setRecette($recette);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::RECETTE_ADD, $recetteEvent);
            return $this->redirectToRoute('app_recette_show');
        }
        return $this->render("recette/add.html.twig", [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}" , name="app_recette_edit")
     */
    public function editRecette(Request $request, Recipe $recette){

        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $recetteEvent = $this->get(RecetteEvent::class);
            /** @var RecetteEvent $recetteEvent */
            $recetteEvent->setRecette($recette);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::RECETTE_EDIT, $recetteEvent);
            return $this->redirectToRoute('app_recette_show');
        }
        return $this->render("recette/edit.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_recette_recetteid")
     */
    public function showRecetteId(Request $request, Recipe $recette){
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository(Comment::class)->findBy(['recipe' => $recette->getId()]);

        $vote = $this->get(Vote::class);
        $form = $this->createForm(VoteType::class, $vote);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voteEvent = $this->get(VoteEvent::class);
            /** @var VoteEvent $voteEvent */
            $voteEvent->setVote($vote);
            $voteEvent->setRecette($recette);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::VOTE_ADD, $voteEvent);
            return $this->redirectToRoute("app_recette_recetteid", ['id'=> $recette->getId()]);
        }

        $comment = $this->get(Comment::class);
        $form2 = $this->createForm(CommentType::class, $comment);

        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $commentEvent = $this->get(CommentEvent::class);
            /** @var CommentEvent $commentEvent */
            $commentEvent->setComment($comment);
            $commentEvent->setRecette($recette);
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::COMMENT_ADD, $commentEvent);
            return $this->redirectToRoute("app_recette_recetteid", ['id'=> $recette->getId()]);
        }
        /**@var \App\Vote\calculeVote $moyenne */
        $moyenne = $this->get(\App\Vote\calculeVote::class);
        $resultat = $moyenne->moyenVote($recette);
        return $this->render('recette/recetteid.html.twig',[
            'recette'=>$recette,
            'comments' => $comments,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'moyenne' => $resultat,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="app_recette_delete")
     */
    public function delete(Recipe $recipe){
        $recetteEvent = $this->get(RecetteEvent::class);
        /** @var RecetteEvent $recetteEvent */
        $recetteEvent->setRecette($recipe);


        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(AppEvent::RECETTE_DELETE, $recetteEvent);

        return $this->redirectToRoute('app_recette_show');
    }
}