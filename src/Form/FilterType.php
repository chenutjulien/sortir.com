<?php

namespace App\Form;

use App\Entity\Filter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('Search', SearchType::class,[
                'label'=>'Le nom de la sortie contient : '
            ])
        ->add('debDate', DateTimeType::class)
        ->add('endDateTime',DateTimeType::class )
        ->add('organiser')
        ->add('registered')
        ->add('unregistered')
        ->add('pastTrip');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
        ]);
    }
}
