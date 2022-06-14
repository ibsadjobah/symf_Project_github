<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class EntreeController extends AbstractController
{
    #[Route('/entree/add', name: 'app_entree')]
    public function index(EntreeRepository $entreeRepository): Response
    {
        
        $entree = new Entree();
        $form =$this->createForm(EntreeType::class , $entree,[
            'action' => $this->generateUrl('entree_add'),
        ]);
        return $this->renderForm('entree/index.html.twig', [
            'entree'=> $entreeRepository->findAll(),
            'form'=>$form,
            'controller_name' => 'EntreeController',
        ]);
    }

    #[Route('/entree', name: 'entree_add')]
    public function add(Request $request, ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getManager();
        $entree = new Entree();
        $produit =new Produit();

        $form = $this->createForm(EntreeType::class, $entree);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entree = $form->getData();

            $entityManager->persist($entree);
            $entityManager->flush();

            $produit= $entityManager->getRepository(Produit::class)->find($entree->getProduit()->getId());
            $stock =$produit->getQtStock() + $entree->getQtE();
            $produit->setQtstock($stock);
            $entityManager->flush();


            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_entree',[               
                'entree'=>$entree,
            ]);
            
        }
        
            return $this->renderForm('entree/index.html.twig',[
                'form' => $form,
               'entree'=>$entree,
            ]);
       

    }

}
