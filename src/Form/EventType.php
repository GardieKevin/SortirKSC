<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array('attr'=>array('class'=>'input', 'type'=>'text', 'placeholder'=>'Name of event ...')))
            ->add('campus',EntityType::class, ['class' => Campus::class,'choice_label'=> 'name'])
            ->add('startingDate')
            ->add('duration', TextType::class, array('attr'=>array('class'=>'input', 'type'=>'text', 'placeholder'=>'Duration ...')))
            ->add('limitInscribeDate')
            ->add('maxInscriptionsNumber', TextType::class, array('attr'=>array('class'=>'input', 'type'=>'text', 'placeholder'=>'Maximum participants ...')))
            ->add('informations', TextType::class, array('attr'=>array('class'=>'textarea', 'placeholder'=>'Description ...')))
            ->add('etat',EntityType::class, ['class'=>Etat::class, 'choice_label'=>'libelle'] );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
