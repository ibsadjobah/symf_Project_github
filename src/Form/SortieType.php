<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateS', DateType::class,[ 'attr'=>['class'=>'form-control', 'form-group', 'require'=>'require'], 'label'=> 'Date de vente'])
            ->add('qtS',   TextType::class,[ 'attr'=>['class'=>'form-control', 'form-group', 'require'=>'require'], 'label'=> 'Quantite de stock'])
            ->add('produit',EntityType::class,['class'=> Produit::class, 'attr'=>['class'=>'form-control', 'form-group', 'require'=>'require'], 'label'=> 'Libelle du Produit'])
            ->add('valider', SubmitType::class, ['attr'=>['class'=>'form-control ', 'class'=>'btn btn-success']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
