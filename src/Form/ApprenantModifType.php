<?php

namespace App\Form;

use App\Entity\Apprenant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprenantModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Telephone')
            ->add('roles')
            ->add('password')
            ->add('Nom')
            ->add('Addresse')
            ->add('Mail')
            ->add('Statut')
            ->add('enable')
            ->add('Prenom')
            ->add('Sex')
            ->add('coursActive')
            ->add('coursAppris')
            ->add('posts')
            ->add('idAutoEcolr')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apprenant::class,
        ]);
    }
}
