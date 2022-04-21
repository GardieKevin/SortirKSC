<?php

namespace App\Form;


use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Etat;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
