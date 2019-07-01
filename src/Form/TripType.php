<?php

namespace App\Form;

use App\Entity\Trip;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'required'=>true
            ])



            ->add('startDateTime',DateTimeType::class, [
                'label'=>'Heure et date de départ',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'input-append'],
                'required'=>'true',

//                'attr'=>['class'=>'form-control datetimepicker-input']
                //-> CI-DESSUS POUR LE DATE PICKER

            ])
            ->add('endDateTime', DateTimeType::class, [
                'label'=>'Heure et date de fin',
                'required'=>true,
            ])
            ->add('maxRegistration', IntegerType::class, [
                'label'=>'Nombre de personnes maximum',
                'required'=>'true'
            ])
            ->add('informations', TextareaType::class, [
                'label'=>'Description',
                'attr'=>['placeholder'=>"Détaillez l'activité proposée"]
            ])

            ->add('Spot', EntityType::class, [
                'class' => 'App\Entity\Spot',
                'choice_label' => 'name',
                'placeholder' => 'Choisir un lieu',
                'label' => 'Lieu :'
            ])

            ->add('State', EntityType::class, [
                'class' => 'App\Entity\State',
                'choice_label' => 'name',
                'data' => 'Créée',
                'label' => 'Status :'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
