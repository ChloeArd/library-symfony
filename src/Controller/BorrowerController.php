<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BorrowerController extends AbstractController {

    /**
     * find one borrower
     * @return Response
     */
    #[Route('/borrower/{id}', name: 'borrower')]
    public function index($id, BorrowerRepository $repository): Response {
        $borrower = $repository->find($id);
        return $this->render('borrower/index.html.twig', ["borrower" => $borrower]);
    }

    /**
     * add a borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/add', name: 'borrower_add')]
    public function add(EntityManagerInterface $entityManager): Response {

        $borrower = new Borrower();
        $borrower
            ->setFirstname("Chloé")
            ->setLastname("Ard")
            ->setEmail("chloe.ard@gmail.com")
            ->setPassword("1234!");

        $entityManager->persist($borrower);
        $entityManager->flush();

        $id = $borrower->getId();

        return $this->redirect("/borrower/$id");

        //return $this->render('borrower/add.html.twig');
    }

    /**
     * update a borrower
     * @param Borrower $borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/update/{id}', name: 'borrower_update')]
    public function update(Borrower $borrower, EntityManagerInterface $entityManager): Response {
        $borrower
            ->setFirstname("user")
            ->setLastname("name")
            ->setEmail("user@mail.com")
            ->setPassword("1234!");

        $entityManager->flush();

        $id = $borrower->getId();

        return $this->redirect("/borrower/$id");

        //return $this->render('borrower/update.html.twig');
    }

    /**
     * delete a borrower
     * @param Borrower $borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/delete/{id}', name: 'borrower_delete')]
    public function delete(Borrower $borrower, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($borrower);
        $entityManager->flush();

        $id = $borrower->getId();

        return $this->redirect("/borrower/$id");

        //return $this->render('borrower/delete.html.twig');
    }

}
