<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('media', MediaType::class)
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            )

        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $article = $event->getData();
        $form = $event->getForm();

        /** @var Article $article */
        if($article!==null) {
            if ($article->getId() !== null) {
                $form->add('register', SubmitType::class, ['label' => 'Register']);
            }
        }else {
            $form->add('modif', SubmitType::class, ['label' => 'Modif']);
        }

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
