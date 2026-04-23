<?php

namespace App\Form;

use App\Entity\ConditionnementImmunologique;
use App\Enum\ConditionnementImmunosuppresseur;
use App\Enum\RisqueImmunologique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConditionnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('risqueImmunologique', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), RisqueImmunologique::cases()),
                    RisqueImmunologique::cases()
                ),
                'label' => 'Risque immunologique',
                'required' => false,
            ])
            ->add('conditionnementImmunosuppresseur', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(fn($e) => $e->getLabel(), ConditionnementImmunosuppresseur::cases()),
                    ConditionnementImmunosuppresseur::cases()
                ),
                'label' => 'Conditionnement immunosuppresseur',
                'required' => false,
            ])
            ->add('commentaireRisqueImmunologique', TextType::class, ['label' => 'Commentaire risque', 'required' => false])
            ->add('commentaireConditionnement', TextType::class, ['label' => 'Commentaire conditionnement', 'required' => false]);
    }
    
    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => ConditionnementImmunologique::class,
        ]);
    }
}