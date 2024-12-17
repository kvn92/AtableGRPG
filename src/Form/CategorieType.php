<?php 

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', TextType::class, [
                'label' => 'Catégorie',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Exemple : France',
                    'class' => 'form-control'
                ]
            ])
            ->add('statutCategories', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => true,
                    'Inactif' => false
                ],
                'expanded' => true, // Affichage sous forme de boutons radio
                'multiple' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('submit', SubmitType::class, [
                'label' => $options['forms'] ? 'Ajouter' : 'Modifier',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
            'forms' => false
        ]);
    }
}
