<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $items = [
            [
                'id' => 1,
                'title' => 'NEWS',
                'description' => 'Description du premier élément',
                'image' => 'IMG_4123.jpg',
                'category_id' => 1 
            ],
            [
                'id' => 2,
                'title' => 'Next Date',
                'description' => 'Description du deuxième élément',
                'image' => 'IMG_2117.jpg',
                'category_id' => 2
            ],
            [
                'id' => 3,
                'title' => 'Get The Albums',
                'description' => 'Description du troisième élément',
                'image' => 'IMG_3659.jpg',
                'category_id' => 3
            ],
        ];

        return $this->render('home/index.html.twig', [
            'message' => 'Cher visiteur',
            'items' => $items,
        ]);
    }
}
