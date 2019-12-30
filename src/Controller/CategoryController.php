<?php


namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Services\SlugifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/category", name="admin_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/add", name="index")
     * @return Response
     */
    public function index(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $result = $this->getDoctrine()
                ->getRepository(Category::class)
                ->findBy(['name' => $data->getName()]);
            if ($result == null) {
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($category);
                 $entityManager->flush();
            }
        }

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('admin/category.html.twig',
            [
                'form' => $form->createView(),
                'categories' => $categories,
            ]);

    }
}
