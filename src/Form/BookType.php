<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = new \DateTime();
        $years2 = new \DateTime();
        $years3 = new \DateTime();
        $builder
            ->add('name', TextType::class, ["label" => "Nom"])
            ->add('picture', UrlType::class, ['label' => "Photo de la couverture"])
            ->add('author', TextType::class, ["label" => "Auteur(s)"])
            ->add('date', DateType::class, [
                "label" => "Date de sortie",
                "placeholder" => " ",
                "years" => range((int)$years->format("Y"), (int)$years->modify("- 200years")->format("Y")),
                ])
            ->add('description', TextareaType::class, [
                'label' => "Résumé",
                "attr" => [
                    "rows" => 10,
                    "cols" => 10
                ]
            ])
            ->add('reserved', DateType::class, [
                "label" => "Réservation",
                "required" => false,
                "placeholder" => "",
                "empty_data" => null,
                "days" => range(1, 31),
                "months" => range(1, 12),
                "years" => range((int)$years2->format("Y"), (int)$years2->modify("+ 1years")->format("Y"))
            ])
            ->add('recovery', DateType::class, [
                "label" => "Récupération",
                "required" => false,
                "placeholder" => "",
                "empty_data" => null,
                "days" => range(1, 31),
                "months" => range(1, 12),
                "years" => range((int)$years3->format("Y"), (int)$years3->modify("+ 1years")->format("Y"))
            ])
            ->add('borrower', EntityType::class, [
                "label" => "Choissiez un emprunteur",
                "required" => false,
                "empty_data" => null,
                "class" => Borrower::class,
                "choice_label" => function(Borrower $borrower) {
                    return $borrower->getFirstname() . " " . $borrower->getLastname();
                },
                "placeholder" => "",
            ])
            ->add('category', EntityType::class, [
                "label" => "Choissiez une catégorie",
                "class" => Category::class,
                "choice_label" => "name",
                "placeholder" => "",
                "constraints" => [
                    new NotBlank([
                        "message" => "Veuillez choisir une catégorie"
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, ["label" => "Enregistrer"] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
