<?php
/**
 * Created by PhpStorm.
 * User: camilo
 * Date: 12/11/18
 * Time: 16:31
 */

namespace App\Controller;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show(Category $category) :Response
    {
        return $this->render('category.html.twig', ['category' => $category]);
    }
}