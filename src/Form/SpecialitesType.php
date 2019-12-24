<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('specialite')
            ->add('service',EntityType::class,[
                'class'=>Service::class,
                'choice_label'=>'libelle',
            ])
            ->add('medecins', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'Nom',
            'multiple' => true,
            'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialites::class,
        ]);
    }
}