<?php

namespace App\Form;

use App\Entity\Trip;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label'=>'Nom de la sortie',
                'attr'=>['placeholder'=>'Insérez le titre de votre évènement ici...'],
                'required'=>true])
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
            ->add('name', EntityType::class, [
                'class'=>'App\Entity\Spot',
                'choice_label'=>'name',
                'label'=>'Lieu'
            ])
            ->add('street', EntityType::class, [
                'class'=>'App\Entity\Spot',
                'choice_label'=>'street',
                'label'=>'Rue'
            ])
            ->add('latitude', EntityType::class, [
                'class'=>'App\Entity\Spot',
                'choice_label'=>'latitude',
                'label'=>'Latitude'
            ])
            ->add('longitude', EntityType::class, [
                'class'=>'App\Entity\Spot',
                'choice_label'=>'longitude',
                'label'=>'Longitude'
            ])

//            ->add('cancelReason', TextareaType::class, [
//                'label'=>"Raison d'annulation",
//                'attr'=>["Détaillez-nous les raisons d'annulation"]
//            ])

            // Sera demandée si l'organisateur annule la sortie
//            ->add('organiser')//Nous n'utiliserons pas les variables à partir de là (=clefs)
//            ->add('registereds')
//            ->add('state')
//            ->add('spot', TextareaType::class,[
//                'label'=>'Lieu'
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trip::class,
        ]);
    }
}
