<?php

namespace App\Form;

use App\Entity\Spot;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('city', EntityType::class, [
                'class'=>'App\Entity\City',
                'choice_label'=>'name',
                'label'=>'Ville'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spot::class,
        ]);
    }
}
