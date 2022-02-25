<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\BorrowerRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController {

    /**
     * all book by id to category
     * @param int $idCategory
     * @param BookRepository $repository
     * @return Response
     */
    #[Route('/category-book/{idCategory}', name: 'book')]
    public function index(int $idCategory, BookRepository $repository): Response {

        $books = $repository->findBy(['category' => $idCategory]);

        return $this->render('book/index.html.twig', ["books" => $books]);
    }

    /** add a book
     * @param EntityManagerInterface $entityManager
     * @param BorrowerRepository $borrowerRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('/book/add', name: 'book_add')]
    public function add(EntityManagerInterface $entityManager, BorrowerRepository $borrowerRepository, CategoryRepository $categoryRepository): Response {

        $book = new Book();
        $borrower = $borrowerRepository->find(1);
        $category = $categoryRepository->find(6);
        $book
            ->setName("Rendez moi mes poux")
            ->setPicture("https://pim.rue-des-livres.com/a9/h7/e6/9782075164863_600x799.jpg")
            ->setAuthor("PEF")
            ->setDate("2022")
            ->setDescription("Un jour, Mathieu sent que sa tête le démange. Et, en se grattant très fort, il découvre qu'il a des poux... Une formule magique trouvée par hasard lui permet de les apprivoiser et d'en faire ses amis. Heureux, Mathieu coule des jours paisibles avec ses poux, jusqu'au jour où sa mère découvre les intrus...")
            ->setBorrower(null) // person who borrowed the book
            ->setCategory($category);

        $entityManager->persist($book);
        $entityManager->flush();

        $id = $book->getCategory()->getId();

        return $this->redirect("/category-book/$id");

        //return $this->render('book/add.html.twig');
    }

    /**
     * display one book
     * @param int $idBook
     * @param BookRepository $repository
     * @return Response
     */
    #[Route('/book/{idBook}', name: 'book_one')]
    public function oneBook(int $idBook, BookRepository $repository): Response {

        $book = $repository->find($idBook);

        return $this->render('book/oneBook.html.twig', ["book" => $book]);
    }

    /**
     * update a book
     * @param Book $book
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/book/update/{id}', name: 'book_update')]
    public function update(Book $book, EntityManagerInterface $entityManager): Response {

        $book
            ->setName("test")
            ->setPicture("https://via.placeholder.com/200x100")
            ->setAuthor("Author")
            ->setDate("date")
            ->setDescription("Un résumer du livre");

        $entityManager->flush();

        return $this->render('book/update.html.twig');
    }

    /**
     * add a borrower to book
     * @param Book $book
     * @param EntityManagerInterface $entityManager
     * @param BorrowerRepository $borrowerRepository
     * @return Response
     */
    #[Route('/book/update-borrower/{id}', name: 'book_update_borrower')]
    public function updateBorrower(Book $book, EntityManagerInterface $entityManager, BorrowerRepository $borrowerRepository): Response {

        $borrower = $borrowerRepository->find(1);

        $book->setBorrower($borrower);

        $entityManager->flush();

        $id = $book->getId();

        return $this->redirect("/book/$id");
    }

    #[Route('/book/update-borrower-delete/{id}', name: 'book_update_borrower_delete')]
    public function updateBorrowerDelete(Book $book, EntityManagerInterface $entityManager): Response {

        $book->setBorrower(null);

        $entityManager->flush();

        $id = $book->getId();

        return $this->redirect("/book/$id");
    }

    /**
     * delete a book
     * @param Book $category
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $repository
     * @return Response
     */
    #[Route('/book/delete/{id}', name: 'book_delete')]
    public function delete(Book $book, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($book);
        $entityManager->flush();

        $id = $book->getCategory()->getId();

        return $this->redirect("/category-book/$id");

        //return $this->render('book/delete.html.twig');
    }
}
