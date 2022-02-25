<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Shelf;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

    /**
     * @param int $id
     * @param CategoryRepository $repository
     * @return Response
     */
    #[Route('/borrower-category/{id}/', name: 'category')]
    public function index(int $id, CategoryRepository $repository): Response {

        $categorys = $repository->findBy(['shelf' => $id]);

        return $this->render('category/index.html.twig', ['categorys' => $categorys]);
    }

    /**
     * add a category
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/category/add', name: 'category_add')]
    public function add(EntityManagerInterface $entityManager, ShelfRepository $repository): Response {

        $category = new Category();
        $s = $repository->find(4);
        $category->setName("Religion & spiritualité");
        $category->setShelf($s);

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->render('category/add.html.twig');
    }

    /**
     * update a category
     * @param Category $category
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/category/update/{id}', name: 'category_update')]
    public function update(Category $category, EntityManagerInterface $entityManager): Response {

        $category->setName("Sport");

        $entityManager->flush();

        return $this->render('category/update.html.twig');
    }

    /**
     * delete a category and book who is associated
     * @param Category $category
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $repository
     * @return Response
     */
    #[Route('/category/delete/{id}', name: 'category_delete')]
    public function delete(Category $category, EntityManagerInterface $entityManager): Response {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->render('category/delete.html.twig');
    }
}
