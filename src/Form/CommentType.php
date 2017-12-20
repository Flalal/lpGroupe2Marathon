<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 16:27
 */

namespace App\Form;


use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("content", TextareaType::class)
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ["data_class", Comment::class]
        );
    }
    public function onPreSetData(FormEvent $event)
    {
        $comment = $event->getData();
        $form = $event->getForm();


        $form->add('submit',SubmitType::class);

    }


}