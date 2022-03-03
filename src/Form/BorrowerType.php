<?php

namespace App\Form;

use App\Entity\Borrower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ["label" => "Prénom"])
            ->add('lastname', TextType::class, ["label" => "Nom de famille"])
            ->add('email', EmailType::class, ["label" => "Adresse-Mail"])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => "Mot de passe",
                'first_options' => [
                    'label' => 'Entrez votre mot de passe'
                ],
                'second_options' => [
                    'label' => 'Répétez votre mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class, ["label" => "Enregistrer"] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrower::class,
        ]);
    }
}
