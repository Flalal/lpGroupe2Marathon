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
use App\Event\RecetteEvent;
use App\Form\RecetteType;
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
     * @Route("/", name="app_recette_show")
     */
    public function showRecette(){
        $em = $this->getDoctrine()->getManager();
        $recettes = $em->getRepository(Recipe::class)->findAll();
        return $this->render('recette/show.html.twig',['recettes'=>$recettes,]);

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
        return $this->render("recette/add.html.twig", ['form' => $form->createView(),]);
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
        return $this->render("recette/edit.html.twig", ['form' => $form->createView(),]);
    }

    /**
     * @Route("/{id}", name="app_recette_recetteId")
     */
    public function showRecetteId(Recipe $recette){
        $em = $this->getDoctrine()->getManager();
        $recette = $em->getRepository(Recipe::class)->findOneBy(['id'=>$recette->getId()]);
        $comments = $em->getRepository(Comment::class)->findBy(['recipe' => $recette->getId()]);
        return $this->render('recette/recetteId.html.twig',['recette'=>$recette, 'comments' => $comments]);
    }



}