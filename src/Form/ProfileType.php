<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use App\Entity\MagicalLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatarFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Effacer',
                'download_label' => 'Téléchager',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
                ])
            
            ->add('nom')
            ->add('prenom')
            ->add('pseudo')
            ->add('biographie')
            ->add('birthday', null, [
                'widget' => 'single_text',
            ])
            ->add('magicalLevel', EntityType::class, [
                'class' => MagicalLevel::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
