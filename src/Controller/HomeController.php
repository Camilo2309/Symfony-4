<?php
/**
 * Created by PhpStorm.
 * User: camilo
 * Date: 05/11/18
 * Time: 08:26
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */

    public function index()
    {

        return $this->render('home.html.twig');

    }
}