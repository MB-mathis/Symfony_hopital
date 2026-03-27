<?php
namespace App\Form;

use App\Entity\PatientUserShare;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientUserShareType extends AbstractType
{
    public const FIELD_USER = 'user';
    public const FIELD_EXPIRES_AT = 'expiresAt';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FIELD_USER, EntityType::class, [
                'class' => User::class,
                'choice_label' => fn(User $user) => $user->getPrenom().' '.$user->getNom(),
                'placeholder' => 'Sélectionnez un utilisateur',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PatientUserShare::class,
        ]);
    }
}