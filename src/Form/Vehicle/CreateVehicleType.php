<?php

declare(strict_types=1);

namespace App\Form\Vehicle;

use App\Enum\VehicleCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateVehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('registrationNumber', TextType::class, [
                'label' => "Immatriculation",
            ])
            ->add('brand', ChoiceType::class, [
                'label' => "Marque",
                'choices' => [
                    'Audi' => 'Audi',
                    'Volvo' => 'Volvo',
                    'Opel' => 'Opel',
                    'Renault' => 'Renault',
                    'Peugeot' => 'Peugeot',
                    'Lamborghini' => 'Lamborghini',
                    'BMW' => 'BMW',
                    'Porsche' => 'Porsche',
                    'Citroen' => 'Citroen',
                    'Seat' => 'Seat',
                ]
            ])
            ->add('model', TextType::class, [
                'label' => "Modèle",
                "required" => false,
                "constraints" => [
                    new NotBlank(),
                ]
            ])
            ->add('category', EnumType::class, [
                'label' => 'Catégorie',
                'class' => VehicleCategory::class,
                'choice_label' => fn (VehicleCategory $c) => $c->label(),
                'placeholder' => 'Choisir une catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Vehicle']);
    }
}
