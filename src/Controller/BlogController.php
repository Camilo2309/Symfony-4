<?php
/**
 * Created by PhpStorm.
 * User: camilo
 * Date: 12/11/18
 * Time: 09:47
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * Matches /blog exactly
     * @Route("/blog/page/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/index.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/blog/{slug}", requirements={"slug"="[a-z0-9-]*"}, methods={"GET"}, name="blog_show")
     */
    public function show($slug)
    {

        if (empty($slug)) {
            return new Response("<h1>Article Sans Titre</h1>");

        } else {

            $slug = (ucwords(str_replace("-", " ", $slug)));
            return $this->render('blog/show.html.twig', ['slug' => $slug]);
        }
    }
}