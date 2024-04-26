<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Profile;
use App\Controller\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profile::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('pseudo'),
            DateField::new('birthday'),
            DateTimeField::new('createdAt')
            ->setFormTypeOptions([
                'disabled' => true, // Désactive le champ dans le formulaire
            ])
            ->hideOnForm(),
            TextareaField::new('biographie'),
            AssociationField::new('idUser'),
            AssociationField::new('magicalLevel'),
            BooleanField::new('isActive'),
            ImageField::new('avatarName', 'Avatar')
            ->setBasePath('/images/avatars')
            ->setUploadDir('public/images/avatars')  // définissez le répertoire d'upload ici
            ->onlyOnIndex(),
    
            VichImageField::new('avatarFile', 'Image File')
            ->setTemplatePath('admin/field/vich_image_widget.html.twig') // chemin vers votre nouveau template personnalisé
            ->hideOnIndex()
        ];
    }
    
}
