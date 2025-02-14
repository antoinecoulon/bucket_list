<?php

namespace App\Controller;

use App\Entity\Wish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_', methods: ['GET'])]
final class WishController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $wishRepository = $entityManager->getRepository(Wish::class);
        $wishes = $wishRepository->findAllOrderedByDate();

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail($id, Wish $wish): Response
    {
        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }
}