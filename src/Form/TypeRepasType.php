<?php

namespace App\Form;

use App\Entity\TypeRepas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeRepasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeRepas',TextType::class, [
                'label' => 'Type de repas',
                'required' => true,
                'attr' => [
                    'placeholder' => 'exemeple Dessert'
                ]])
            ->add('StatutTypeRepas',ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => true,
                    'Désactivé' => false,
                ],
                'expanded' => true, // Affichage sous forme de boutons radio
                'multiple' => false, // Une seule option possible)

                
             ]) 
             
             ->add('submit',SubmitType::class,[
                'label'=>$options['forms']?'Ajouter':'Modifier'
            ])
             ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeRepas::class,
            'forms'=>true
        ]);
    }
}
