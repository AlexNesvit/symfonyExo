<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VichImageField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setTemplatePath('admin/field/vich_image_widget.html.twig')
            ->setLabel($label)
            ->setFormType(VichImageType::class);
    }

}