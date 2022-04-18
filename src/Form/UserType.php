<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use mysql_xdevapi\RowResult;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('email', TextType::class,
            ['label'=> 'Email'])
            ->add('plainPassword', PasswordType::class, [
                'label'=>'Password',
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
            ->add('lastname', TextType::class,
                ['label'=>'Surname :'])
            ->add('firstname', TextType::class,

                ['label'=>'firstname :'])
            ->add('pseudo', TextType::class,

                ['label'=>'firstname'])
            ->add('pseudo', TextType::class,
            ['label'=>'Pseudo'])

            ->add('phone', TextType::class,
                ['label'=>'Phone :'])
            ->add('photo',FileType::class,
                ['label'=>'Avatar : ',
                    'mapped'=>false,
                    'required'=>false,
                    'constraints'=>[
                        new File([
                            'maxSize'=>'1024k',
                            'mimeTypes'=>[
                                'image/gif',
                                'image/jpeg',
                                'image/jpg',
                                'image/png',
                            ],
                            'mimeTypesMessage'=>'Choose a valid format : gif,jpeg,jpg,png',
                        ])
                    ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
