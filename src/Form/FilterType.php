<?php

namespace App\Form;

use App\Entity\Filter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Site', EntityType::class, [
                'class' => 'App\Entity\Site',
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Site :'
            ])
            ->add('search', SearchType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false
            ])
            ->add('debDate', DateTimeType::class, [
                'label' => 'Heure et date de début',
                'widget' => 'choice',
                'format' => 'd-M-y HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'required' => true
            ])
            ->add('endDateTime', DateTimeType::class, [
                'label' => 'Heure et date de fin',
                'widget' => 'choice',
                'format' => 'd-M-y HH:mm:ss',
                'model_timezone' => 'Europe/Paris',
                'required' => true
            ])
            ->add('organiser', CheckboxType::class,
                array('label'=>'Organisateur',
                    'required'=>false)
            )
            ->add('registered', CheckboxType::class,
                array('label'=>'Inscrit',
                    'required'=>false)
            )

            ->add('unregistered', CheckboxType::class,
                array('label'=>'Non inscrit',
                    'required'=>false)
            )
            ->add('pastTrip', CheckboxType::class,
                array('label'=>'Sorties passées',
                    'required'=>false)

            )
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
        ]);
    }
}
