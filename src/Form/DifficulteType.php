<?php

namespace App\Form;

use App\Entity\Difficulte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DifficulteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('difficultes',TextType::class,['label'=>'Difficulte',
            'required'=>true,'attr'=>['placeholder'=>'Exemple Facile']
            ])
            ->add('statutDifficultes',ChoiceType::class,[
                'label'=>'Statut','choices'=>[
                    'Actif'=>true,'Inactif'=>false]
                    ,'expanded' => true, // Affichage sous forme de bout
                    'multiple' => false, // Une seule option possible
                               
            ])
            ->add('submit',SubmitType::class,[
                'label'=>$options['forms']?'Ajouter':'Modifier'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Difficulte::class,
            'forms'=>true
        ]);
    }
}
