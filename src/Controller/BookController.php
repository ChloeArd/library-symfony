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

    /** add a book
     * @param EntityManagerInterface $entityManager
     * @param BorrowerRepository $borrowerRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('/book/add', name: 'book_add')]
    public function add(EntityManagerInterface $entityManager, BorrowerRepository $borrowerRepository, CategoryRepository $categoryRepository): Response {

        $book = new Book();
        $borrower = $borrowerRepository->find(2);
        $category = $categoryRepository->find(6);
        $book
            ->setName("Le petit prince")
            ->setPicture("https://cdn.cultura.com/cdn-cgi/image/width=1280/media/pim/TITELIVE/10_9782070612758_1_75.jpg")
            ->setAuthor("Antoine de Saint-Exupéry")
            ->setDate("1943")
            ->setDescription("Le narrateur est un aviateur qui, à la suite d'une panne de moteur, a dû se poser en catastrophe dans le désert du Sahara et tente seul de réparer son avion (Antoine de Saint-Exupéry se met en scène lui-même dans son œuvre).")
            ->setBorrower($borrower) // person who borrowed the book
            ->setCategory($category);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render('book/add.html.twig');
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

        return $this->render('book/delete.html.twig');
    }
}
