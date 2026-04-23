<?php

namespace App\Form;

use App\Entity\Prelevement;
use App\Enum\TypeEn;
use App\Enum\CoteRein;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrelevementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            // --- Dates et heures ---
            ->add('dateDeclampage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date Déclampage',
                'required' => false,
            ])
            ->add('heureDeclampage', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure Déclampage',
                'required' => false,
            ])
            ->add('ischemieTotale', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Ischémie totale',
                'required' => false,
            ])

            // --- Choix côtés et type EN via enums ---
            ->add('cotePrelevement', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), CoteRein::cases()),
                    CoteRein::cases()
                ),
                'label' => 'Côté prélèvement',
                'required' => false,
            ])
            ->add('coteTransplantation', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), CoteRein::cases()),
                    CoteRein::cases()
                ),
                'label' => 'Côté transplantation',
                'required' => false,
            ])
            ->add('en', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), TypeEn::cases()),
                    TypeEn::cases()
                ),
                'label' => 'Type EN',
                'required' => false,
            ])

            // --- Paramètres techniques ---
            ->add('dureeAnastomoses', IntegerType::class, [
                'label' => 'Durée anastomoses (min)',
                'required' => false,
            ])
            ->add('sondeJJ', CheckboxType::class, [
                'label' => 'Sonde JJ',
                'required' => false,
            ])

            // --- Commentaire ---
            ->add('commentairePrelevement', TextType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([
            'data_class' => Prelevement::class,
        ]);
    }
}