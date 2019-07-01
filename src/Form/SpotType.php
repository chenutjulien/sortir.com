<?php

namespace App\Form;

use App\Entity\Spot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
               'attr'=>[
                   'label'=>'Nom',
                   'required'=>'true'
               ]
                ])
            ->add('street', TextType::class, [
                'attr'=> [
                    'label'=> 'Nom de la rue',
                    'required'=>'true'
                ]
            ])
            ->add('latitude', IntegerType::class, [
                'attr'=>[
                    'label'=> 'Latitude',
                    'required'=>'true'
                ]
            ])
            ->add('longitude', IntegerType::class, [
                'attr'=>[
                    'label'=> 'Latitude',
                    'required'=>'true'
                ]
            ])
            ->add('City', EntityType::class, [
                'class' => 'App\Entity\City',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une ville',
                'required' => true,
                'label' => 'Ville :'
            ])


//            ->add('city', EntityType::class, [
//                'class'=>'App\Entity\City',
//                'choice_label'=>'name',
//                'label'=>'Ville'
//            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
