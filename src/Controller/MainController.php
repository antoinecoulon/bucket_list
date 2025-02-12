<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig', [
            'site_name' => 'Bucket List',
            'user' => 'Admin'
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        $json = json_decode(file_get_contents('../data/team.json'), true);
        return $this->render('main/about.html.twig', [
            'json' => $json
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [

        ]);
    }
}
