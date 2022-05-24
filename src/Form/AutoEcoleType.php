<?php

namespace App\Form;

use App\Entity\AutoEcole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutoEcoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Description',TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('Note',IntegerType::class,  ['attr'=>['class'=>'form-control']] )
            ->add('Telephone',TelType::class,["attr"=>["class"=>"form-control","placeholder"=>"Telephone"],"label"=>" "])
            ->add('password',PasswordType::class,["attr"=>["class"=>"form-control","placeholder"=>"Password"],"label"=>" "])
            ->add('Mail',TextType::class,["attr"=>["class"=>"form-control","placeholder"=>"Mail"],"label"=>" "])
            ->add('Addresse',TextType::class,["attr"=>["class"=>"form-control","placeholder"=>"Addresse"],"label"=>" "])
            ->add("image", FileType::class, ['mapped'=>false,'attr'=>['class'=>'form-control','name'=>'image','required'=>false]])
            ->add('Enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary w-100 waves-effect waves-light']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutoEcole::class,
        ]);
    }
}
