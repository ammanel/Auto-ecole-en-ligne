<?php

namespace App\Form;

use App\Entity\ModeDePaiement;
use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idModePayement',EntityType::class,[
                'class'=>ModeDePaiement::class, 'choice_label'=>function($modepayement){
                    return $modepayement->getNomPaiement();
                },'attr'=>['class'=>'form-control']])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
