<?php

namespace App\Form;

use App\Entity\Serologie;
use StatutVirologiqueDR;
use App\Enum\StatutVirologiqueToxo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerologieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // --- CMV et EBV via enum StatutVirologiqueDR ---
            ->add('cmvStatus', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), StatutVirologiqueDR::cases()),
                    StatutVirologiqueDR::cases()
                ),
                'label' => 'CMV Status',
                'required' => false,
            ])
            ->add('ebvStatus', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), StatutVirologiqueDR::cases()),
                    StatutVirologiqueDR::cases()
                ),
                'label' => 'EBV Status',
                'required' => false,
            ])

            // --- Toxoplasmose via enum ---
            ->add('toxoStatus', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), StatutVirologiqueToxo::cases()),
                    StatutVirologiqueToxo::cases()
                ),
                'label' => 'Toxoplasmose Status',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serologie::class,
        ]);
    }
}