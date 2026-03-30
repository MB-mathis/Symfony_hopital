<?php

namespace App\Form;

use App\Model\DonneurTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DonneurDecedeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $decede = DonneurTemplate::getDefaultData()[DonneurTemplate::KEY_DECEDE];

        $builder
            ->add('ville_origine', TextType::class, ['required' => false])
            ->add('cause_deces', TextType::class, ['required' => false])
            ->add('commentaire_cause_deces', TextType::class, ['required' => false])
            ->add('donneur_criteres_etendus', TextType::class, ['required' => false])
            ->add('definition_dce', TextType::class, ['required' => false])
            ->add('arret_cardiaque', TextType::class, ['required' => false])
            ->add('duree_arret_cardiaque', TextType::class, ['required' => false])
            ->add('PA_moyenne', TextType::class, ['required' => false])
            ->add('amines', TextType::class, ['required' => false])
            ->add('transfusion', TextType::class, ['required' => false])
            ->add('CGR', TextType::class, ['required' => false])
            ->add('CPA', TextType::class, ['required' => false])
            ->add('PFC', TextType::class, ['required' => false])
            ->add('creatinine_arrivee', TextType::class, ['required' => false])
            ->add('creatinine_prelevement', TextType::class, ['required' => false])
            ->add('uretere', TextType::class, ['required' => false])
            ->add('plaie_digestive', TextType::class, ['required' => false])
            ->add('liquide_conservation', TextType::class, ['required' => false])
            ->add('infection_liquide', TextType::class, ['required' => false]);
    }
}