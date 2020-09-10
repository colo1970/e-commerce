<?php

namespace App\Form;

use App\Entity\UserAdresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UserAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse',TextType::class, [
                'label'=>false, 
                'attr'=>['placeholder'=>'Adresse']
            ])
            ->add('cp',TextType::class, [
                'label'=>false, 
                'attr'=>['placeholder'=>'Cp']
            ])
            ->add('ville',TextType::class, [
                'label'=>false, 
                'attr'=>['placeholder'=>'Ville']
            ])
            ->add('pays',TextType::class, [
                'label'=>false, 
                'attr'=>['placeholder'=>'Pays']
            ])
            ->add('complements',TextType::class, [
                'label'=>false,
                'required'=>false, 
                'attr'=>['placeholder'=>'Compléments']
            ])
            //->add('dateCreAt')
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAdresses::class,
        ]);
    }
}
