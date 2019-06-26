<?php

namespace App\Form;

use App\Entity\User;
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
                    'required'=>true
                ]
            ])
            ->add('name', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre nom',
                    'required'=>true
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre prénom',
                    'required'=>true
                ]
            ])
            ->add('picture', FileType::class, [
                'attr'=> [
                    'placeholder'=>'Votre jolie trombine',
                    'required'=>false
                ]
            ])
            ->add('mail', EmailType::class, [
                'attr'=> [
                    'placeholder'=>'Votre adresse mail',
                    'required'=>true
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
            ->add('phoneNumber', TelType::class, [
                'attr'=> [
                    'placeholder'=>'Votre télephone',
                    'required'=>true
                ]
            ])
//            ->add('site', CheckboxType::class,
//                array('label'=>'Chartres de Bretagne',
//                    'required'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
