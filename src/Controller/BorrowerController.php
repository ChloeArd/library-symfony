<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Form\BorrowerType;
use App\Repository\BookRepository;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class BorrowerController extends AbstractController {

    /**
     * add a borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/add', name: 'borrower_add')]
    public function add(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {

        $borrower = new Borrower();
        $form = $this->createForm(BorrowerType::class, $borrower);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrower);
            $entityManager->flush();
            $message = $translator->trans('Account created successfully');
            $this->addFlash("success", $message);
            return $this->redirect("/borrower");
        }
        return $this->render('borrower/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * find one borrower
     * @return Response
     */
    #[Route('/borrower', name: 'borrower_list')]
    public function index(BorrowerRepository $repository): Response {

        $borrowers = $repository->findAll();
        return $this->render('borrower/index.html.twig', ["borrowers" => $borrowers]);
    }

    /**
     * update a borrower
     * @param Borrower $borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/update/{id}', name: 'borrower_update')]
    public function update(Borrower $borrower, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {

        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $message = $translator->trans('Account modified successfully');
            $this->addFlash("success", $message);
            $id = $borrower->getId();
            return $this->redirect("/borrower/$id");
        }
        return $this->render('borrower/update.html.twig', ["form" => $form->createView()]);
    }

    /**
     * delete a borrower
     * set the borrower to null, reserved and recovery to the book when the user is deleted to make it available
     * @param Borrower $borrower
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/borrower/delete/{id}', name: 'borrower_delete')]
    public function delete(Borrower $borrower, EntityManagerInterface $entityManager, BookRepository $repository, TranslatorInterface $translator): Response {
        $entityManager->remove($borrower);
        $entityManager->flush();

        $id = $borrower->getId();

        $book = $repository->findBy(['borrower' => $id]);

        $message = $translator->trans('Account deleted successfully');
        $this->addFlash("success", $message);

        // put a null
        foreach ($book as $b) {
            $id2 = $b->getId();
            return $this->redirect("/book/update-borrower-delete/$id2");
        }
        return $this->redirect("/");
    }
}