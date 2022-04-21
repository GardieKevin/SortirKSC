<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', TextType::class, array('attr' => array('class' => 'input', 'type' => 'email', 'placeholder' => 'alexsmith@gmail.com')))
            ->add('firstname', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Yvon')))
            ->add('lastname', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Lavaler')))
            ->add('pseudo', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'BigBossDu44')))
            ->add('phone', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Fait un effort ...')))
            ->add('photo', FileType::class,
                [
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/gif',
                                'image/jpeg',
                                'image/jpg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Choose a valid format : gif,jpeg,jpg,png',
                        ])
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
