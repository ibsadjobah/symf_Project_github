<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, ['attr' => ['class'=>'form-control form-group', 'require'=>'require'], 'label'=>'Libelle Produit'])
            ->add('qtStock', TextType::class, ['attr' => ['class'=>'form-control form-group', 'require'=>'require'], 'label'=>'Quantite Stock'])
            ->add('categories',EntityType::class,['class'=> Categories::class,'attr' => [ 'class'=>'form-control form-group', 'require'=>'require'], 'label'=>'categories produit'])

            ->add('valider', SubmitType::class, ['attr'=>['class'=>'form-control ', 'class'=>'btn btn-success']])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
