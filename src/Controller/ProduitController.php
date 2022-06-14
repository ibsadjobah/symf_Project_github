<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categories;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class ProduitController extends AbstractController
{
    #[Route('/produit/add', name: 'app_produit')]
    public function index(ProduitRepository $produitRepository): Response
    {
          $produit = new Produit();
          $categories= new Categories();
        $form =$this->createForm(ProduitType::class , $produit,[
            'action' => $this->generateUrl('produit_add'),
        ]);
        return $this->renderForm('produit/index.html.twig', [ 
           'produit'=> $produitRepository->findAll(),
           'form'=>$form,
            //'form'=>$form->createView(),
          
           'controller_name' => 'ProduitController',
        ]);

       
    }

    #[Route('/produit', name: 'produit_add')]
    public function add(Request $request, ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getManager();
        $produits = new Produit();
        $categories =new Categories();



        $form = $this->createForm(ProduitType::class, $produits);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $produits = $form->getData();

            $entityManager->persist($produits);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database
            //$categories= $entityManager->getRepository(Categories::class)->find($produits->getCategories()->getId());


            return $this->redirectToRoute('app_produit',[               
                'produit'=>$produits,
            ]);
            
        }
        
            return $this->renderForm('produit/index.html.twig',[
                'form' => $form,
               'produit'=>$produits,
            ]);
       

    }

   

    
    
}
