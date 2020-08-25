<?php

namespace App\Form;

use App\Entity\Tva;
use App\Form\ImageType;
use App\Entity\Produits;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prixht')
            ->add('description')
            ->add('quantite')
            ->add('poids')
            ->add('disponibilite')
            //->add('dateCreaAt')
            ->add('image', ImageType::class)
            ->add('categorie', EntityType::class, [
                'class'=> Categories::class,
                'choice_label' => 'nom',
            ])
            ->add('tva', EntityType::class, [
                'class'=> Tva::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
