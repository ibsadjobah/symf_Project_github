<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Entity\Produit;
use App\Repository\SortieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class SortieController extends AbstractController
{
    #[Route('/sortie/add', name: 'app_sortie')]
    public function index(SortieRepository $sortieRepository): Response
    {
        $sortie =new Sortie();

        $form= $this->createForm(SortieType::class, $sortie, [
            'action' => $this->generateUrl('sortie_add'),
        ]);
        return $this->renderForm('sortie/index.html.twig', [
            'sortie'=>$sortieRepository->findAll(),
            'form'=>$form,
            'controller_name' => 'SortieController',
        ]);
    }

    #[Route('/sortie', name: 'sortie_add')]
    public function add(Request $request, ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $sortie =new Sortie();
        $produit=new Produit();

        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $sortie = $form->getData();

            $entityManager->persist($sortie);
            $entityManager->flush();

            $produit= $entityManager->getRepository(Produit::class)->find($sortie->getProduit()->getId());
            $stock =$produit->getQtStock() - $sortie->getQtS();
            $produit->setQtstock($stock);
            $entityManager->flush();


            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_sortie',[               
                'sortie'=>$sortie,
            ]);
            
        }
        
            return $this->renderForm('sortie/index.html.twig',[
                'form' => $form,
               'sortie'=>$sortie,
            ]);
       

    }
}
