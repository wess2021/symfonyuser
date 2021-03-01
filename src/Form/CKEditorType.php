<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Category;
use App\Entity\Article;

class CKEditorType extends AbstractType
{public function getParent()
    {
        return 'FOS\CKEditorBundle\Form\Type\CKEditorType';
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'ckeditor', array(
            'config' => array(
                'extraPlugins' => 'templates',
                'templates'    => 'my_template',
            ),
            'templates' => array(
                'my_template' => array(
                    'imagesPath' => '/bundles/mybundle/templates/images',
                    'templates'  => array(
                        array(
                            'title'               => 'My Template',
                            'image'               => 'images.jpg',
                            'description'         => 'My awesome template',
                            'template'            => 'AppBundle:CKEditor:template.html.twig',
                            'template_parameters' => array('foo' => 'bar'),
                        ),
                        // ...
                    ),
                ),
            ),
        ));
    }
       
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        
            'data_class' => Article::class,
        ]);
    }
}
