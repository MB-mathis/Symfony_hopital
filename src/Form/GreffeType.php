<?php

namespace App\Form;

use App\Entity\Greffe;
use App\Entity\Donneur;
use App\Entity\DossierMedical;
use App\Entity\Chirurgien;
use TypeGreffe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class GreffeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            // --- Champs principaux de Greffe ---
            ->add('donneur', EntityType::class, [
                'class' => Donneur::class,
                'choice_label' => 'numeroCrista', // adapter selon l'attribut du Donneur
                'label' => 'Donneur',
                'required' => true,
            ])
            ->add('dossierMedical', EntityType::class, [
                'class' => DossierMedical::class,
                'choice_label' => 'id',
                'label' => 'Dossier Médical',
                'required' => true,
            ])
            ->add('chirurgien', EntityType::class, [
                'class' => Chirurgien::class,
                'choice_label' => 'nom', // adapter
                'label' => 'Chirurgien',
                'required' => false,
            ])
            ->add('dateGreffe', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de greffe',
                'required' => true,
            ])
            ->add('rangGreffe', IntegerType::class, [
                'label' => 'Rang de greffe',
                'required' => true,
            ])
            ->add('typeGreffe', ChoiceType::class, [
                'choices' => TypeGreffe::cases(),
                'choice_label' => fn(TypeGreffe $t) => $t->getLabel(),
                'choice_value' => fn(?TypeGreffe $t) => $t?->value,
                'label' => 'Type de greffe',
                'required' => true,
            ])
            ->add('greffonFonctionnel', CheckboxType::class, [
                'label' => 'Greffon fonctionnel',
                'required' => false,
            ])
            ->add('dialyse', CheckboxType::class, [
                'label' => 'Dialyse',
                'required' => false,
            ])
            ->add('protocole', CheckboxType::class, [
                'label' => 'Protocole',
                'required' => false,
            ])
            ->add('dateFinFonctionGreffon', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date fin fonction greffon',
                'required' => false,
            ])
            ->add('causeFinFonctionGreffon', TextType::class, [
                'label' => 'Cause fin fonction greffon',
                'required' => false,
            ])

            // --- Sous-forms liés via OneToOne ---
            ->add('prelevement', PrelevementType::class, [
                'label' => 'Prélèvement',
                'required' => false,
            ])
            ->add('serologie', SerologieType::class, [
                'label' => 'Sérologie',
                'required' => false,
            ])
            ->add('conditionnementImmunologique', ConditionnementType::class, [
                'label' => 'Conditionnement immunologique',
                'required' => false,
            ])
            ->add('groupeHLA', GroupeHLAType::class, [
                'label' => 'Groupe HLA',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Greffe::class,
        ]);
    }
}