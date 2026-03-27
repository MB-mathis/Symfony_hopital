<?php

namespace App\Form;

use App\Entity\DossierMedical;
use App\Entity\Patient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Enum\Sexe;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PatientType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
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
            ->add('ville')
            ->add('codePostal')
            ->add('telephone')
            ->add('email')
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('dossierMedical', EntityType::class, [
            //     'class' => DossierMedical::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('createdBy', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('updatedBy', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
