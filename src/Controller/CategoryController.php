<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function add(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $message = $translator->trans('Category added successfully');
            $this->addFlash("success", $message);
            $id = $category->getShelf()->getId();
            return $this->redirect("/borrower-category/$id");
        }
        return $this->render('category/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * update a category
     * @param Category $category
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/category/update/{id}', name: 'category_update')]
    public function update(Category $category, Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $message = $translator->trans('Category modified successfully');
            $this->addFlash("success", $message);
            $id = $category->getShelf()->getId();
            return $this->redirect("/borrower-category/$id");
        }
        return $this->render('category/update.html.twig', ['form' => $form->createView()]);
    }

    /**
     * delete a category and book who is associated
     * @param Category $category
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $repository
     * @return Response
     */
    #[Route('/category/delete/{id}', name: 'category_delete')]
    public function delete(Category $category, EntityManagerInterface $entityManager, CategoryRepository $repository, TranslatorInterface $translator): Response {

        $repository->delete($category->getId());
        $id = $category->getShelf()->getId();
        $message = $translator->trans('Category deleted successfully');
        $this->addFlash("success", $message);
        return $this->redirect("/borrower-category/$id");
    }
}
