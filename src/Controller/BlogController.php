<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\Mapping as ORM;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index( ArticleRepository $repo)
    {
       
        $articles=$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            
        ]);
    }
   /**
 * @Route("/product/title/{title}", name="ser_show")
 */
public function mind($title=null, ArticleRepository $articleRepository,Request $request)
{
    $request->query->get('title');
    $request->getMethod();
    $article = $articleRepository
        ->findTitle($title);
        return $this->render('search/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $article,
            
        ]);

    // ...
}
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    
    }
    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request):Response
    {
        $article=new Article();
       $entityManager = $this->getDoctrine()->getManager();
       
        $form =$this->createFormBuilder($article)
                    ->add('title')
                    ->add('content',CKEditorType::Class)
                    ->add('image')
                    ->add('category')
                    
                    ->getForm();
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt( new \DateTime());
            }
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('blog_show',['id'=> $article->getId()]);
        } 
        return $this-> render('blog/create.html.twig',[
            'formArticle'=> $form->createView(),
            'editMode'=>$article->getId()!==null
           
        ]);
    }
    /**
    * @Route("/blog/{id}/edit", name="blog_edit")
    */
    public function edit(Article $article,Request $request)
    {$entityManager = $this->getDoctrine()->getManager();
        $form =$this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->add('category')
                    ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt( new \DateTime());
            }
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('blog_show',['id'=> $article->getId()]);
        } 
        return $this-> render('blog/create.html.twig',[
            'formArticle'=> $form->createView(),
            'editMode'=>$article->getId()!==null
           
        ]);

    }
    
   
    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Request $request, Article $article)
    {
        $comment= new Comment();
        $entityManager = $this->getDoctrine()->getManager();
        $form= $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if(!$comment->getId()){
                $comment->setCreatedAt( new \DateTime())
                        ->setArticle($article);
            }
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('blog_show',['id'=> $article->getId()]);
        }
        return $this->render('blog/show.html.twig',[
            'article'=>$article,
            'commentForm' =>$form->createView()
        ]);
    
    }
    
}
