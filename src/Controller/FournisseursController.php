<?php

namespace App\Controller;

use App\Entity\Fournisseurs;
use App\Form\FournisseursType;
use App\Repository\FournisseursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/fournisseurs')]
class FournisseursController extends AbstractController
{
    // #[Route('/fournisseurs', name: 'app_fournisseurs')]
    // public function index(): Response
    // {
    //     return $this->render('fournisseurs/index.html.twig', [
    //         'controller_name' => 'FournisseursController',
    //     ]);
    // }

    #[Route('/', name: 'app_fournisseurs')]
    public function index(FournisseursRepository $fournisseursRepo): Response
    {
       $fournisseurs = $fournisseursRepo->findAll();
       return $this->render('fournisseurs/index.html.twig', [
        'fournisseurs' => $fournisseurs
       ]);
    }

    #[Route('/{id}/show', name: 'app_fournisseurs_show')]
    public function show(int $id, FournisseursRepository $fournisseursRepo): Response
    {
        $fournisseurs = $fournisseursRepo->find($id);

        return $this->render('fournisseurs/show.html.twig', [
            'fournisseurs' => $fournisseurs,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fournisseurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseurs $fournisseurs, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(fournisseursType::class, $fournisseurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseurs', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('fournisseurs/edit.html.twig', [
            'fournisseurs' => $fournisseurs,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_fournisseurs_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Fournisseurs $fournisseurs, EntityManagerInterface $entityManager): Response
    {
       $entityManager->remove($fournisseurs);
       $entityManager->flush();

       return $this->redirectToRoute('app_fournisseurs');
    }

    #[Route('/{id}/add', name: 'app_fournisseurs_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fournisseurs = new Fournisseurs();

        $form = $this->createForm(FournisseursType::class, $fournisseurs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($fournisseurs);
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseurs');
        }
      
        return $this->render('fournisseurs/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/par_raison_sociale', name: 'app_fournisseurs_par_raison_sociale')]
    public function parRaisonSociale(FournisseursRepository $fournisseursRepo): Response
    {
       $fournisseurs = $fournisseursRepo->findBy([], ['Raison_sociale' => 'ASC']);
       return $this->render('fournisseurs/par_raison_sociale.html.twig', [
        'fournisseurs' => $fournisseurs
       ]);
    }

    #[Route('/par_localite', name: 'app_fournisseurs_par_localite')]
    public function parLocalite(FournisseursRepository $fournisseursRepo): Response
    {
       $fournisseurs = $fournisseursRepo->findBy([], ['Localite' => 'ASC']);
       return $this->render('fournisseurs/par_localite.html.twig', [
        'fournisseurs' => $fournisseurs
       ]);
    }

    #[Route('/par_pays', name: 'app_fournisseurs_par_pays')]
    public function parPays(FournisseursRepository $fournisseursRepo): Response
    {
    //    $fournisseurs = $fournisseursRepo->findBy([], ['Pays' => 'ASC']);

       $fournisseurs = $fournisseursRepo->findDistinctPays();
       return $this->render('fournisseurs/par_pays.html.twig', [
        'fournisseurs' => $fournisseurs
       ]);
    }
    
}
