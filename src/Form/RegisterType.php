<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre identifiant',
                    'required'=>true,
                    'label' => 'Pseudo'
                ]
            ])
            ->add('name', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre nom',
                    'required'=>true,
                    'label' => 'Nom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre prénom',
                    'required'=>true,
                    'label'=> 'Prénom'
                ]
            ])
//            ->add('picture', FileType::class, [
//                'attr'=> [
//                    'placeholder'=>'Votre jolie trombine',
//                    'required'=>false
//                ]
//            ])
            ->add('mail', EmailType::class, [
                'attr'=> [
                    'placeholder'=>'Votre adresse mail',
                    'required'=>true,
                    'label'=>'Email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message'=>'Vous n\'avez pas saisi le même mot de passe',
                'first_options'=>[
                    'label'=>'Mot de passe'
                ],
                'second_options' => [
                    'label'=>'Confirmation du mot de passe'
                ]
            ])
            ->add('administrator', CheckboxType::class,
                array('label'=>'Administrateur',
                    'required'=>false))
            ->add('active', CheckboxType::class,
                array('label'=>'active',
                    'required'=>false))
            ->add('phoneNumber')
            ->add('Site', EntityType::class,[
                    'class' => 'App\Entity\Site',
                    'choice_label' => 'name',
                    'placeholder' => 'Veuillez choisir un site',
                    'required' => true,
                    'expanded' => true,
                    'label' => 'Site :'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
