<?php

declare(strict_types=1);

namespace App\Form\Vehicle;

use App\Entity\Vehicle;
use App\Enum\VehicleCategory;
use App\Enum\VehicleEnergy;
use App\Enum\VehicleStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Identification
            ->add('registrationNumber', TextType::class, [
                'label' => 'Immatriculation',
            ])
            ->add('vin', TextType::class, [
                'label' => 'N° de série (VIN)',
                'required' => false,
            ])
            ->add('category', EnumType::class, [
                'label' => 'Catégorie',
                'class' => VehicleCategory::class,
                'choice_label' => fn (VehicleCategory $c) => $c->label(),
            ])
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'expanded' => true,
                'class' => VehicleStatus::class,
                'choice_label' => fn (VehicleStatus $s) => $s->label(),
            ])

            // Marque / modèle
            ->add('brand', ChoiceType::class, [
                'label' => 'Marque',
                'required' => false,
                'placeholder' => 'Choisir une marque',
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
                ],
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'required' => false,
            ])
            ->add('variantType', TextType::class, [
                'label' => 'Version / type (D.2)',
                'required' => false,
            ])
            ->add('cnit', TextType::class, [
                'label' => 'CNIT (D.2.1)',
                'required' => false,
            ])
            ->add('color', TextType::class, [
                'label' => 'Couleur',
                'required' => false,
            ])

            // Dates
            ->add('firstRegistrationDate', DateType::class, [
                'label' => '1re mise en circulation (B)',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('currentRegistrationDate', DateType::class, [
                'label' => 'Date du certificat actuel (I)',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])

            // Masses
            ->add('maxLadenMass', IntegerType::class, [
                'label' => 'PTAC (F.1, kg)',
                'required' => false,
            ])
            ->add('maxCombinedMass', IntegerType::class, [
                'label' => 'PTRA (F.3, kg)',
                'required' => false,
            ])
            ->add('unladenMass', IntegerType::class, [
                'label' => 'Poids à vide (G, kg)',
                'required' => false,
            ])

            // Classification
            ->add('euCategory', TextType::class, [
                'label' => 'Catégorie CE (J)',
                'required' => false,
            ])
            ->add('nationalGenre', TextType::class, [
                'label' => 'Genre national (J.1)',
                'required' => false,
            ])
            ->add('bodyType', TextType::class, [
                'label' => 'Carrosserie (J.3)',
                'required' => false,
            ])
            ->add('typeApprovalNumber', TextType::class, [
                'label' => 'N° de réception (K)',
                'required' => false,
            ])

            // Motorisation
            ->add('energy', EnumType::class, [
                'label' => 'Énergie (P.3)',
                'class' => VehicleEnergy::class,
                'choice_label' => fn (VehicleEnergy $e) => $e->label(),
                'required' => false,
                'placeholder' => 'Choisir une énergie',
            ])
            ->add('engineDisplacement', IntegerType::class, [
                'label' => 'Cylindrée (P.1, cm³)',
                'required' => false,
            ])
            ->add('netPowerKw', NumberType::class, [
                'label' => 'Puissance nette (P.2, kW)',
                'required' => false,
            ])
            ->add('fiscalPower', IntegerType::class, [
                'label' => 'Puissance fiscale (P.6, CV)',
                'required' => false,
            ])
            ->add('co2Emissions', IntegerType::class, [
                'label' => 'CO₂ (V.7, g/km)',
                'required' => false,
            ])
            ->add('seatCount', IntegerType::class, [
                'label' => 'Places assises (S.1)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Vehicle::class]);
    }
}
