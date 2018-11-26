<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("blog/categories", name="all_categories")
     * @param CategoryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllCategories(CategoryRepository $repository)
    {
        $categories = $repository->findAll();

        return $this->render("blog/allCategories.html.twig", [
            'categories' => $categories,
        ]);
    }
}
