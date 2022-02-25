<?php

namespace App\Controller;

use App\Entity\Shelf;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('shelf/index.html.twig', [
            'shelfs' => $shelfs,
        ]);
    }

    /**
     * add a borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/add', name: 'shelf_add')]
    public function add(EntityManagerInterface $entityManager): Response {

        $shelf = new Shelf();
        $shelf->setName("Etagère 5");

        $entityManager->persist($shelf);
        $entityManager->flush();

        return $this->redirectToRoute("shelf");

        //return $this->render('shelf/add.html.twig');
    }

    /**
     * update a shelf
     * @param Shelf $shelf
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/update/{id}', name: 'shelf_update')]
    public function update(Shelf $shelf, EntityManagerInterface $entityManager): Response {

        $shelf->setName("Etagère test");

        $entityManager->flush();

        return $this->redirectToRoute("shelf");

        //return $this->render('shelf/update.html.twig');
    }

    /**
     * delete a shelf
     * @param Shelf $shelf
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/shelf/delete/{id}', name: 'shelf_delete')]
    public function delete(Shelf $shelf, ShelfRepository $repository, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($shelf);
        $entityManager->flush();

        return $this->redirectToRoute("shelf");

        //return $this->render('borrower/delete.html.twig');
    }

}
