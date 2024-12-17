<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Difficulte;
use App\Entity\Recette;
use App\Entity\TypeRepas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreRecettes',TextType::class,['label'=>'Recette',
            'required'=>true,'attr'=>['placeholder'=>'Exemple Facile']])
            ->add('preparations',TextareaType::class,['label'=>'Prépartion',
            'required'=>true,'attr'=>['placeholder'=>'Exemple 300gr de farine']])
            ->add('photoRecettes',FileType::class,[
                'label'=>'Photo','mapped'=>false,
               

                ])

                ->add('categories',EntityType::class,[
                    'class'=>Categorie::class,
                    'choice_label' => 'categories',
                    'label' => 'Categories',
                    'placeholder' => 'Sélectionner une categorie',
    
                   ]) 
                   ->add('difficultes',EntityType::class,[
                    'class'=>Difficulte::class,
                    'choice_label'=>'difficultes',
                    'label'=> 'Difficulte',
                    'placeholder' => 'Sélectionner une difficulte',

                   ])
                   ->add('repas',EntityType::class,[
                    'class'=>TypeRepas::class,
                    'choice_label'=>'typeRepas',
                    'label'=> 'TypeRepas',
                    'placeholder' => 'Sélectionner une Loki',

                   ])
            ->add('statutRecettes',ChoiceType::class,[
                'label'=>'Statut','choices'=>[
                    'Actif'=>true,'Inactif'=>false]
                    ,'expanded' => true, 
                    'multiple' => false, 
                               
            ])
            ->add('submit',SubmitType::class,[
                'label'=>$options['forms']?'Ajouter':'Modifier'
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
            'forms'=>true
        ]);
    }
}
