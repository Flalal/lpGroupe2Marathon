<?php
/**
 * Created by PhpStorm.
 * User: bastien.cornu
 * Date: 20/12/17
 * Time: 20:05
 */

namespace App\Form;


use App\Entity\Vote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for($i = 0; $i <= 5; $i++ ){
            $choices [$i] = $i;
        }
        $builder
            ->add("value",ChoiceType::class,
                array(
                    "label"=>"Voter",
        'choices' => $choices,
        'expanded' => true,
        'multiple' => false
    ))
            ->add("submit", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Vote::class,
        ]);
    }


}