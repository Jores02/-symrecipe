<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom de la recette']
            ])
            ->add('time', IntegerType::class, [
                'label' => 'Temps (en minutes)',
                'required' => false,
                'attr' => ['class' => 'form-control', 'min' => 1, 'max' => 1440]
            ])
            ->add('nbPersons', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'required' => false,
                'attr' => ['class' => 'form-control', 'min' => 1, 'max' => 50]
            ])
            ->add('difficulty', IntegerType::class, [
                'label' => 'Difficulté',
                'required' => false,
                'attr' => ['class' => 'form-control', 'min' => 1, 'max' => 5]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix (€)',
                'required' => false,
                'attr' => ['class' => 'form-control', 'min' => 0, 'max' => 1000]
            ])
            ->add('isFavorite', CheckboxType::class, [
                'label' => 'Favori ?',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, // cases à cocher
                'label' => 'Ingrédients',
                'attr' => ['class' => 'form-check'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
