<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wish', name: 'wish_', methods: ['GET'])]
final class WishController extends AbstractController
{
    /** Appel de la fonction personalisée du repository.
     * Affiche tous les wishes triés du plus récent au plus ancien
     * @param WishRepository $wishRepository
     * @return Response
     */
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAllOrderedByDate();

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    /** Récupère l'id du wish cliqué et affiche les détails
     * @param $id
     * @param Wish $wish
     * @return Response
     */
    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail($id, Wish $wish): Response
    {
        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }

    // Future pour gérer le form
//    #[Route('/wish/new', name: 'wish_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $wish = new Wish();
//        $form = $this->createForm(WishType::class, $wish);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($wish);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('wish_list');
//        }
//
//        return $this->render('wish/new.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

}