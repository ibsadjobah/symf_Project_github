<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class CategoriesController extends AbstractController

{
    #[Route('/categories/add', name: 'app_categories')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories =new Categories();

        $form= $this->createForm(CategoriesType::class, $categories, [
            'action' => $this->generateUrl('categories_add'),
        ]);
        return $this->renderForm('categories/index.html.twig', [
            'categories'=>$categoriesRepository->findAll(),
            'form'=>$form,
            'controller_name' => 'CategoriesController',
        ]);
    }

    #[Route('/categories', name: 'categories_add')]
    public function add(Request $request, ManagerRegistry $doctrine):Response
    {
        $entityManager = $doctrine->getManager();
        $categories = new Categories();

        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $categories = $form->getData();

            $entityManager->persist($categories);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_categories',[               
                'categories'=>$categories,
            ]);
            
        }
        
            return $this->renderForm('categories/index.html.twig',[
                'form' => $form,
               'categories'=>$categories,
            ]);
       

    }

}
