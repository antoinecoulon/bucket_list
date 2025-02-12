<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_', methods: ['GET'])]
final class WishController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig', []);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail($id): Response
    {
        return $this->render('wish/detail.html.twig', []);
    }
}