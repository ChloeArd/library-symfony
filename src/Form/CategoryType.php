<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Shelf;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom"])
            ->add('shelf', EntityType::class, [
                "label" => "Choissiez une étagère",
                "class" => Shelf::class,
                "choice_label" => "name",
                "placeholder" => "",
                "constraints" => [
                    new NotBlank([
                        "message" => "Veuillez choisir une étagère"
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, ["label" => "Enregistrer"] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
