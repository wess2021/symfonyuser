<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Form\CatType;


class CatController extends AbstractController
{
    /**
     * @Route("/cat", name="cat")
     */
    public function cat(Request $request)
    {$entityManager = $this->getDoctrine()->getManager();
        $category=new Category();
        $form=$this->createForm(CatType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();
        }
        return $this->render('cat/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}
