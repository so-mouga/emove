<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Agency;
use App\Entity\Type;
use App\Entity\Rental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', TextType::class)
            ->add('model', TextType::class)
            ->add('color', TextType::class)
            ->add('mileage', IntegerType::class)
            ->add('numberPlate', TextType::class)
            ->add('vehiculeCondition', TextType::class)
            ->add('nbDoors', IntegerType::class)
            ->add('nbSeets', IntegerType::class)
            ->add('indexPrice', IntegerType::class)
            ->add('agency', EntityType::class, ['class' => Agency::class])
            ->add('type', EntityType::class, ['class' => Type::class])
            ->add('rental',  EntityType::class, ['class' => Rental::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }
}
