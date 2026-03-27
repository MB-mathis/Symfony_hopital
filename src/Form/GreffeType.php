<?php

namespace App\Form;

use App\Entity\Chirurgien;
use App\Entity\Donneur;
use App\Entity\DossierMedical;
use App\Entity\Greffe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GreffeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('dateGreffe', null, [
                'widget' => 'single_text',
            ])
            ->add('rangGreffe')
            ->add('typeGreffe')
            ->add('greffonFonctionnel')
            ->add('dateFinFonctionGreffon', null, [
                'widget' => 'single_text',
            ])
            ->add('causeFinFonctionGreffon')
            ->add('dialyse')
            ->add('dateDerniereDialyse', null, [
                'widget' => 'single_text',
            ])
            ->add('protocole')
            ->add('data')
            ->add('donneur', EntityType::class, [
                'class' => Donneur::class,
                'choice_label' => 'id',
            ])
            ->add('dossierMedical', EntityType::class, [
                'class' => DossierMedical::class,
                'choice_label' => 'id',
            ])
            ->add('chirurgien', EntityType::class, [
                'class' => Chirurgien::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Greffe::class,
        ]);
    }
}
