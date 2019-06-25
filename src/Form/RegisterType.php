<?php

namespace App\Form;

use App\Entity\User;
use function PHPSTORM_META\type;
use Symfony\Component\Form\AbstractType;
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
                    'placeholder'=>'Votre identifiant'
                ]
            ])
            ->add('name', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre nom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre prénom'
                ]
            ])
            ->add('picture', TextType::class, [
                'attr'=> [
                    'placeholder'=>'Votre jolie trombine'
                ]
            ])
            ->add('mail')
            ->add('password')
            ->add('administrator')
            ->add('active')
            ->add('phoneNumber')
            ->add('site')
            ->add('inscriptions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
