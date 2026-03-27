<?php

namespace App\Form;

use App\Entity\Donneur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Enum\TypeDonneur;
use App\Enum\GroupeSanguin;
use App\Enum\Sexe;

class DonneurType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('groupeSanguin', ChoiceType::class, [
                'choices' => [
                    'A+' => GroupeSanguin::A_POS,
                    'A-' => GroupeSanguin::A_NEG,
                    'B+' => GroupeSanguin::B_POS,
                    'B-' => GroupeSanguin::B_NEG,
                    'AB+' => GroupeSanguin::AB_POS,
                    'AB-' => GroupeSanguin::AB_NEG,
                    'O+' => GroupeSanguin::O_POS,
                    'O-' => GroupeSanguin::O_NEG,
                    'AB' => GroupeSanguin::AB,
                    'A' => GroupeSanguin::A,
                    'B' => GroupeSanguin::B,
                    'O' => GroupeSanguin::O,
                ],
                'choice_label' => fn(GroupeSanguin $gs) => match($gs) {
                    GroupeSanguin::A_POS => 'A+',
                    GroupeSanguin::A_NEG => 'A-',
                    GroupeSanguin::B_POS => 'B+',
                    GroupeSanguin::B_NEG => 'B-',
                    GroupeSanguin::AB_POS => 'AB+',
                    GroupeSanguin::AB_NEG => 'AB-',
                    GroupeSanguin::O_POS => 'O+',
                    GroupeSanguin::O_NEG => 'O-',
                    GroupeSanguin::AB => 'AB',
                    GroupeSanguin::A => 'A',
                    GroupeSanguin::B => 'B',
                    GroupeSanguin::O => 'O',
                },
                ])
                ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => Sexe::M,
                    'Femme' => Sexe::F,
                    'Autre' => Sexe::Autre,
                ],
                'choice_label' => fn(Sexe $sex) => match($sex) {
                    Sexe::M => 'Homme',
                    Sexe::F => 'Femme',
                    Sexe::Autre => 'Autre',
                },
            ])
            ->add('taille')
            ->add('data')
            ->add('typeDonneur', ChoiceType::class, [
                'choices' => [
                    'Vivant' => TypeDonneur::VIVANT,
                    'Décédé' => TypeDonneur::DECEDE,
                ],
                'choice_label' => fn(TypeDonneur $td) => match($td) {
                    TypeDonneur::VIVANT => 'vivant',
                    TypeDonneur::DECEDE => 'décédé',
                },
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('poids')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('numeroCrista')
            ->add('imc')
            ->add('dfg')
            ->add('clairanceCalculee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Donneur::class,
        ]);
    }
}
