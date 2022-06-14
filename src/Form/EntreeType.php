<?php

namespace App\Form;

use App\Entity\Entree;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('dateE',  DateType::class, ['attr' => ['class'=>'form-control form-group', 'require'=>'require'], 'label'=>'Date d\'achat'])
            ->add('qtE',    TextType::class, ['attr' => ['class'=>'form-control form-group', 'require'=>'require'], 'label'=>'Quantite Achete'])
            ->add('produit',EntityType::class,['class'=> Produit::class,'attr' => [ 'class'=>'form-control form-group', 'require'=>'require'], 'label'=>'Libelle produit'])
            ->add('valider', SubmitType::class, ['attr'=>['class'=>'form-control ', 'class'=>'btn btn-success']])
           // ->add('produit',EntityType::class, array('class'=> Produit::class, 'label'=>'libelle produit','attr'=>array('form-control form-group')))


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
