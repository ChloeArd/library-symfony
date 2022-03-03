<?php

namespace App\Controller;

use App\Entity\Shelf;
use App\Form\ShelfType;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShelfController extends AbstractController {

    /**
     * all a borrowers
     * @param ShelfRepository $repository
     * @return Response
     */
    #[Route('/', name: 'shelf')]
    public function index(ShelfRepository $repository): Response {

        $shelfs = $repository->findAll();
        return $this->render('shelf/index.html.twig', ['shelfs' => $shelfs,]);
    }

    /**
     * add a borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/add', name: 'shelf_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response {

        $shelf = new Shelf();
        $form = $this->createForm(ShelfType::class, $shelf);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shelf);
            $entityManager->flush();
            $this->addFlash("success", "L'étagère a été créé avec succès !");
            $id = $shelf->getId();
            return $this->redirectToRoute("shelf");
        }
        return $this->render('shelf/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * update a shelf
     * @param Shelf $shelf
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/update/{id}', name: 'shelf_update')]
    public function update(Shelf $shelf, Request $request, EntityManagerInterface $entityManager): Response {

        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "L'étagère a été modifié avec succès ! !");
            return $this->redirectToRoute("shelf");
        }
        return $this->render('shelf/update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * delete a shelf
     * @param Shelf $shelf
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/delete/{id}', name: 'shelf_delete')]
    public function delete(Shelf $shelf, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($shelf);
        $entityManager->flush();
        return $this->redirectToRoute("shelf");
    }
}
