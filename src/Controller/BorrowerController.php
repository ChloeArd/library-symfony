<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Form\BorrowerType;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BorrowerController extends AbstractController {

    /**
     * add a borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/add', name: 'borrower_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response {

        $borrower = new Borrower();
        $form = $this->createForm(BorrowerType::class, $borrower);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrower);
            $entityManager->flush();
            $this->addFlash("success", "Votre compte a été créé avec succès !");
            $id = $borrower->getId();
            return $this->redirect("/borrower/$id");
        }

        return $this->render('borrower/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * find one borrower
     * @return Response
     */
    #[Route('/borrower/{id}', name: 'borrower_list')]
    public function index(int $id, BorrowerRepository $repository): Response {
        $borrower = $repository->find($id);
        return $this->render('borrower/index.html.twig', ["borrower" => $borrower]);
    }

    /**
     * update a borrower
     * @param Borrower $borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/update/{id}', name: 'borrower_update')]
    public function update(Borrower $borrower, Request $request, EntityManagerInterface $entityManager): Response {

        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "Votre compte a été modifié avec succès ! !");
            $id = $borrower->getId();
            return $this->redirect("/borrower/$id");
        }

        return $this->render('borrower/update.html.twig', ["form" => $form->createView()]);
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