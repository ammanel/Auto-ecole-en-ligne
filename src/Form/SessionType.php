<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('dateDebut',DateType::class,['widget' => 'single_text','attr'=>['class'=>'form-control']])
            ->add('dateFin',DateType::class,['widget' => 'single_text','attr'=>['class'=>'form-control']])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
