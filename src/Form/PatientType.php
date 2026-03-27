<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Enum\Sexe;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\PatientUserShareType;


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
            
            // Champ pour partager le patient avec d'autres utilisateurs
            ->add('patientUserShares', CollectionType::class, [
                'entry_type' => PatientUserShareType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false, // important pour Doctrine
                'label' => 'Partages Utilisateurs',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}