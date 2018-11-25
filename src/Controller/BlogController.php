<?php
/**
 * Created by PhpStorm.
 * User: camilo
 * Date: 12/11/18
 * Time: 09:47
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;



class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index() : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }


    /**
     * @Route("/category", name="create_category")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $category = new Category();

//        $form = $this->createFormBuilder($category)
//            ->add('name')
//            ->getForm();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){


            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('create_category');
        }

        return $this->render('blog/allCategories.html.twig', [
            'categories'=>$categories, 'formCategory'=> $form->createView()
        ]);
    }

    /**
     * Matches /blog exactly
     * @Route("/blog/page/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/index.html.twig', ['page' => $page]);
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */

    public function show($slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-") //strip_tags — Supprime les balises HTML et PHP d'une chaîne
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]); // met tout les caracteres en miniscule

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

    /**
     * @Route("/category/{category}", name="blog_show_category")
     */


    public function showByCategory(string $category) : Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy (['name' => $category]); // met tout les caracteres en miniscule

        $category= $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(
                array('title' => $category), // Critere
                array('id' => 'desc'),        // Tri
                3,                              // Limite
                0                               // Offset
            );
        return $this->render('blog/category.html.twig', ['category' => $category]);

    }

}