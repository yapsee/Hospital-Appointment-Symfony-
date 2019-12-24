<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Entity\Specialites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', HiddenType::class)
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'libelle'
            ])
            ->add('specialite', EntityType::class, [
                'class' => Specialites::class,
                'choice_label' => 'specialite',
                'multiple' => true,
                'by_reference' => false,
            ])
            ->add('telephone')

            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}