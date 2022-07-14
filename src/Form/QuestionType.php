<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Proposition;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('coursDedie',EntityType::class,[
                'class'=>Cours::class, 'choice_label'=>function($cours){
                    return $cours-> getTitre();
                },
                'attr'=>['class'=>'form-control']
            
        ])
            ->add('reponse',EntityType::class,[
                'class'=>Proposition::class, 'choice_label'=>function($proposition){
                    return $proposition->getSuggestion();
                },
                'attr'=>['class'=>'form-control'],
                'multiple' => true
            
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
