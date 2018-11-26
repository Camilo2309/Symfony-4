<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("blog/articles", name="all_articles")
     * @param ArticleRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllArticles(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->render("blog/allArticles.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("blog/article/{id}", name="show_article")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article)
    {

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

    public function showNavBar(CategoryRepository $reposi)
    {
        $categories = $reposi->findAll();
        return $this->render('navbar.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @param ArticleRepository $repository
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/category/{id}", name="category_articles")
     */
    public function articlesInCategory (ArticleRepository $repository, Category $category)
    {
        $articles = $repository->findAll();

        return $this->render("blog/articlesInCategory.html.twig", [
            'articles' => $articles,
            'category' => $category
        ]);
    }


    /**
     * @Route("blog/new", name="new_article")
     * @Route("/blog/{id}/edit", name="blog_edit")
     * @param Article|null $article
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {

        if(!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getId()){

                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);

            $manager->flush();

            return $this->redirectToRoute('show_article', ['id' => $article->getId()]);
        }


        return $this->render('blog/form.html.twig', [

            'formArticle' => $form->createView(),

            'editMode' => $article->getId() !== null
        ]);
    }



    /**
     * @Route("blog/new/category", name="new_category")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function formCategory(Category $category = null, Request $request, ObjectManager $manager)
    {

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);

            $manager->flush();

            return $this->redirectToRoute('home', ['id' => $category->getId()]);
        }


        return $this->render('blog/formCategory.html.twig', [

            'formCategory' => $form->createView(),

        ]);
    }

}
