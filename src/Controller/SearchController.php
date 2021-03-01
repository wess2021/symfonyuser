<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\SearchRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\SearchType;
use Doctrine\ORM\Mapping as ORM;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Entity\Search;


class SearchController extends AbstractController
{
    /**
     * @Route("/search/{slug}", name="search")
     */
    public function search_article($slug)
    {
        $article =$this->getDoctrine()->getRepository(Article::class)->find($slug);
        
        return $this->render('search.html.twig',[array('article' => $article)]);
    
     
  
       
    }
  
        
}
