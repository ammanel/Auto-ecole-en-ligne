<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Telephone',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('password',PasswordType::class, ['attr'=>['class'=>'form-control']])
            ->add('Nom',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Addresse',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Mail',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Prenom',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary w-100 waves-effect waves-light']]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
