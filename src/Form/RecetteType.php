<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 13:37
 */

namespace App\Form;


use App\Entity\Media;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name")
            ->add("steps", TextareaType::class)
            ->add("ingredients",TextareaType::class)
            ->add("difficulty")
            ->add("preparation_time")
            ->add("cooking_time")
            ->add("materials",TextareaType::class)
            ->add(
                'media',
                EntityType::class,
                [
                    'class' => Media::class,
                    'choice_label' => function (Media $media){
                        return $media->getTitle() ." - " . $media->getType();
                    },
                    'multiple' => false,  // La modif de false par true change les box
                    'expanded' => false,
                ])
            ->add("astuce", TextareaType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Recipe::class,
        ]);
    }

    public function onPreSetData(FormEvent $event)
    {
        $recette = $event->getData();
        $form = $event->getForm();

        if ($recette->getId() !== null) {
        }
        $form->add('Ajouter',SubmitType::class);

    }


}