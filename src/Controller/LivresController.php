<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/livres')]
class LivresController extends AbstractController
{
    // #[Route('/livres', name: 'app_livres')]
    // public function index(): Response
    // {
    //     return $this->render('livres/index.html.twig', [
    //         'controller_name' => 'LivresController',
    //     ]);
    // }

    #[Route('/', name: 'app_livres')]
    public function index(LivresRepository $livresRepo): Response
    {
        $livres = $livresRepo->findAll();
        return $this->render('livres/index.html.twig', [
            'livres' => $livres,
        ]);
    }

    #[Route('/{id}/show', name: 'app_livres_show')]
    public function show(int $id, LivresRepository $livresRepo): Response
    {
        $livre = $livresRepo->find($id);

        return $this->render('livres/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livres $livres, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivresType::class, $livres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_livres', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('livres/edit.html.twig', [
            'livres' => $livres,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_livres_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Livres $livres, EntityManagerInterface $entityManager): Response
    {
       $entityManager->remove($livres);
       $entityManager->flush();

       return $this->redirectToRoute('app_livres');
    }

    #[Route('/{id}/add', name: 'app_livres_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livres = new Livres();

        $form = $this->createForm(LivresType::class, $livres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($livres);
            $entityManager->flush();

            return $this->redirectToRoute('app_livres');
        }
      
        return $this->render('livres/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/par_titre', name: 'app_livres_par_titre')]
    public function parTitre(LivresRepository $livresRepo): Response
    {
       $livres = $livresRepo->findBy([], ['Titre_livre' => 'ASC']);
       return $this->render('livres/par_titre.html.twig', [
        'livres' => $livres
       ]);
    }

    #[Route('/par_auteur', name: 'app_livres_par_auteur')]
    public function parAuteur(LivresRepository $livresRepo): Response
    {
       $livres = $livresRepo->findBy([], ['Nom_auteur' => 'ASC']);
       return $this->render('livres/par_auteur.html.twig', [
        'livres' => $livres
       ]);
    }

    #[Route('/par_editeur', name: 'app_livres_par_editeur')]
    public function parEditeur(LivresRepository $livresRepo): Response
    {
       $livres = $livresRepo->findBy([], ['Editeur' => 'ASC']);
       return $this->render('livres/par_editeur.html.twig', [
        'livres' => $livres
       ]);
    }



}
