<?php

namespace App\Form;

use App\Entity\GroupeHLA;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeHLAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hlaAMismatch', IntegerType::class, ['label' => 'HLA-A Mismatch'])
            ->add('hlaBMismatch', IntegerType::class, ['label' => 'HLA-B Mismatch'])
            ->add('hlaCwMismatch', IntegerType::class, ['label' => 'HLA-Cw Mismatch', 'required' => false])
            ->add('hlaDQMismatch', IntegerType::class, ['label' => 'HLA-DQ Mismatch'])
            ->add('hlaDPMismatch', IntegerType::class, ['label' => 'HLA-DP Mismatch', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeHLA::class,
        ]);
    }
}