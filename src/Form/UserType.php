<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, array('attr' => array('class' => 'input', 'type' => 'email', 'placeholder' => 'alexsmith@gmail.com')))
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Lavaler')))
            ->add('firstname', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Yvon')))
            ->add('pseudo', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'BigBossDu44')))
            ->add('phone', TextType::class, array('attr' => array('class' => 'input', 'type' => 'text', 'placeholder' => 'Fait un effort ...')))
            ->add('photo', FileType::class,
                ['label' => 'Avatar : ',
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
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
