<?php

namespace App\Form;

use App\Entity\Trip;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'Nom de la sortie',
                'attr'=>['placeholder'=>'Insérez le titre de votre évènement ici...'],
                'required'=>true])
            ->add('startDateTime',DateType::class, [
                'label'=>'Heure et Date de départ',
                'required'=>'true'
            ])
            ->add('duration', IntegerType::class, [
                'label'=>'Durée',
                'attr'=>['placeholder'=>'En minutes'],
                'required'=>true,
            ])
            ->add('maxRegistration', IntegerType::class, [
                'label'=>'Nombre de personnes maximum',
                'required'=>'true'
            ])
            ->add('informations', TextType::class, [
                'label'=>'Description',
                'attr'=>['placeholder'=>"Détaillez l'activité proposée"]
            ])
            ->add('cancelReason')// Sera demandée si l'organisateur annule la sortie
            ->add('organiser')//Nous n'utiliserons pas les variables à partir de là (=clefs)
            ->add('registereds')
            ->add('state')
            ->add('spot')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
