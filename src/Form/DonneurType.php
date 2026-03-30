<?php

namespace App\Form;

use App\Entity\Donneur;
use App\Enum\GroupeSanguin;
use App\Enum\Sexe;
use App\Enum\TypeDonneur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DonneurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroCrista', TextType::class, ['label' => 'Numéro CRISTA'])
            ->add('groupeSanguin', ChoiceType::class, [
                'choices' => array_combine(GroupeSanguin::cases(), GroupeSanguin::cases()),
                'label' => 'Groupe sanguin'
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => array_combine(Sexe::cases(), Sexe::cases()),
                'label' => 'Sexe'
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance'
            ])
            ->add('taille', NumberType::class, ['required' => false, 'label' => 'Taille (cm)'])
            ->add('poids', NumberType::class, ['required' => false, 'label' => 'Poids (kg)'])
            ->add('typeDonneur', ChoiceType::class, [
                'choices' => [
                    'Vivant' => TypeDonneur::VIVANT,
                    'Décédé' => TypeDonneur::DECEDE
                ],
                'label' => 'Type de donneur',
                'placeholder' => 'Sélectionnez un type'
            ]);

        // Formulaire conditionnel selon typeDonneur
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $donneur = $event->getData();
            $form = $event->getForm();
            
            $type = $donneur?->getTypeDonneur() ?? null;

            if ($type === TypeDonneur::VIVANT) {
                $form->add('vivantData', DonneurVivantType::class, ['mapped' => false]);
            } elseif ($type === TypeDonneur::DECEDE) {
                $form->add('decedeData', DonneurDecedeType::class, ['mapped' => false]);
            }
        });

        // Gestion dynamique lors du submit
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (($data['typeDonneur'] ?? null) === TypeDonneur::VIVANT->value) {
                $form->add('vivantData', DonneurVivantType::class, ['mapped' => false]);
            } elseif (($data['typeDonneur'] ?? null) === TypeDonneur::DECEDE->value) {
                $form->add('decedeData', DonneurDecedeType::class, ['mapped' => false]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donneur::class,
        ]);
    }
}