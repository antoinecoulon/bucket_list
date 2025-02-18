<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/wish', name: 'wish_', methods: ['GET'])]
final class WishController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SluggerInterface $slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger){
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    /** READ ALL WISHES
     * Appel de la fonction personalisée du repository
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

    /** READ WISH BY ID
     * @param Wish $wish
     * @return Response
     */
    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function detail(Wish $wish): Response
    {
        return $this->render('wish/detail.html.twig', [
            'wish' => $wish
        ]);
    }

    /** CREATE WISH
     * @param Request $request
     * @return Response
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if ($form->get('image')->getData()) {
                    $imageFile = $form->get('image')->getData();
                    $slug = $this->slugger->slug($wish->getTitle());
                    $newFileName = $slug . '-' . uniqid() . '.' . $imageFile->guessExtension();
                    $imageFile->move('assets/uploads/', $newFileName);
                }

                $this->entityManager->persist($wish);
                $this->entityManager->flush();

                $this->addFlash('success', 'Wish was created!');
                return $this->redirectToRoute('wish_list');
            } catch (UniqueConstraintViolationException $e) {
                //TODO: conserver la saisie utilisateur quand erreur
                $form->get('title')->addError(new \Symfony\Component\Form\FormError('This title is already used!'));
            }
        }

        return $this->render('wish/new.html.twig', [
            'wishForm' => $form
        ]);
    }

    /** UPDATE WISH
     * @param Request $request
     * @param Wish $wish
     * @return Response
     */
    #[Route('/edit/{id}', name: 'edit', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Wish $wish): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Wish was updated!');
            return $this->redirectToRoute('wish_list');
        }

        return $this->render('wish/edit.html.twig', [
            'wish' => $wish,
            'wishForm' => $form
        ]);
    }

    /** DELETE WISH
     * @param Wish $wish
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', requirements: ['id'=>'\d+'], methods: ['DELETE'])]
    public function delete(Wish $wish): Response
    {
        $this->entityManager->remove($wish);
        $this->entityManager->flush();

        $this->addFlash('success', 'Wish was deleted!');

        return $this->redirectToRoute('wish_list');
    }

}