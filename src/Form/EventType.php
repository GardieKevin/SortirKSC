<?php

namespace App\Form;


use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('campus', EntityType::class, ['class' => Campus::class, 'choice_label'=> 'name'])
            ->add('startingDate')
            ->add('duration')
            ->add('limitInscribeDate')
            ->add('maxInscriptionsNumber')
            ->add('informations')
            ->add('etat',EntityType::class, ['class'=>Etat::class, 'choice_label'=>'libelle'] )
            ->add('participants',
                EntityType::class,
                [
                    'class'=>User::class,
                    'choice_label' => 'eventRegistrations',
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
