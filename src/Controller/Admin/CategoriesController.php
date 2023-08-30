<?php
namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {

        $categories = $categoriesRepository->findBy([], ['categoryOrder' => 'asc']);
        return $this->render('admin/categories/index.html.twig', compact ('categories'));
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On crée un nouveau produit
        $categorie = new Categories();

        // On crée le formulaire
        $categoriesForm = $this->createForm(CategoriesFormType::class, $categorie);

        // On traite la requête du formulaire
        $categoriesForm->handleRequest($request);

        // On vérifie si lme formulaire est soumis et valide
        if($categoriesForm->isSubmitted() && $categoriesForm->isValid()){

            // On génère le slug
            $slug = $slugger->slug($categorie->getName());

            $categorie->setSlug($slug);

            // On arrondit le prix
            // $prix = $product->getPrice() * 100;
            // $product->setPrice($prix);

            // On stocke
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Categorie ajouté avec succès');

            // On redirige
            return $this->redirectToRoute('admin_products_index');
        }


        // return $this->render('admin/products/add.html.twig', [
        //     'productForm' => $productForm->createView()
        // ]);

        return $this->render('admin/categories/add.html.twig', compact('categoriesForm'));
    }
}