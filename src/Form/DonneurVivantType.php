<?php

namespace App\Form;

use App\Model\DonneurTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DonneurVivantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $vivant = DonneurTemplate::getDefaultData()[DonneurTemplate::KEY_VIVANT];

        $builder
            ->add('nom', TextType::class, ['required' => false])
            ->add('prenom', TextType::class, ['required' => false])
            ->add('lien_parent_recepteur', TextType::class, ['required' => false])
            ->add('commentaire_lien_parent', TextType::class, ['required' => false])
            ->add('creatinine', TextType::class, ['required' => false])
            ->add('clairance_isotopique', TextType::class, ['required' => false])
            ->add('proteinurie', TextType::class, ['required' => false])
            ->add('voie_abord', TextType::class, ['required' => false])
            ->add('robot', TextType::class, ['required' => false])
            ->add('commentaire_clairance', TextType::class, ['required' => false]);
    }
}