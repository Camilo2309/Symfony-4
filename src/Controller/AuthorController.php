<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/author", name="author_")
 */
class AuthorController extends AbstractController
{
    /**
     * Correspond à la route /author/list et au name "author_list"
     * @Route("/list", name="list")
     */
    public function list()
    {
        // ...
    }

    /**
     * Correspond à la route /author/new et au name "author_new"
     * @Route("/new", name="new")
     */
    public function new()
    {
        return $this->redirectToRoute('blog_list', ['page'=>5]);
    }
}