<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $passwordRequired = $options['password_required'];

        $passwordConstraints = [
            new Length(min: 10, minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.'),
        ];

        if ($passwordRequired) {
            $passwordConstraints[] = new NotBlank(message: 'Le mot de passe est obligatoire.');
        }

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => ['autocomplete' => 'off', 'autofocus' => true],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'Gestionnaire' => User::ROLE_MANAGER,
                    'Conducteur' => User::ROLE_DRIVER,
                ],
                'multiple' => true,
                'expanded' => true,
                'help' => 'Un utilisateur peut cumuler les deux rôles.',
                'constraints' => [
                    new Count(min: 1, minMessage: 'Sélectionnez au moins un rôle.'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => $passwordRequired,
                'label' => false,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                'first_options' => [
                    'label' => $passwordRequired ? 'Mot de passe provisoire' : 'Nouveau mot de passe',
                    'help' => $passwordRequired
                        ? '10 caractères minimum. À transmettre à l\'utilisateur.'
                        : 'Laissez vide pour conserver le mot de passe actuel.',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'constraints' => $passwordConstraints,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'password_required' => true,
        ]);
        $resolver->setAllowedTypes('password_required', 'bool');
    }
}
