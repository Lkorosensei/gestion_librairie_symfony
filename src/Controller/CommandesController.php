<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/commandes')]
class CommandesController extends AbstractController
{
    // #[Route('/commandes', name: 'app_commandes')]
    // public function index(): Response
    // {
    //     return $this->render('commandes/index.html.twig', [
    //         'controller_name' => 'CommandesController',
    //     ]);
    // }

    #[Route('/', name:'app_commandes')]
    public function index(CommandesRepository $commandesRepo): Response
    {
        $commandes = $commandesRepo->findAll();
        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/{id}/show', name:'app_commandes_show')]
    public function show(Commandes $commandes): Response
    {
        // $commandes = $commandesRepo->find($id);
        return $this->render('commandes/show.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/{id}/edit', name:'app_commandes_edit')]
    public function edit(int $id,Request $request,CommandesRepository $commandesRepo, EntityManagerInterface $entityManager)
    {
        $commandes = $commandesRepo->find($id);

        $form = $this->createForm(CommandesType::class, $commandes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('commandes/edit.html.twig', [
            'commandes' => $commandes,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name:'app_commandes_delete')]
    public function delete(Request $request, Commandes $commandes, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($commandes);
        $entityManager->flush();

        return $this->redirectToRoute('app_commandes');

    }

    #[Route('/{id}/add', name:'app_commandes_add')]
    public function add(Request $request,CommandesRepository $commandesRepo, EntityManagerInterface $entityManager)
    {
        $commandes = new Commandes;

        $form = $this->createForm(CommandesType::class, $commandes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($commandes);
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('commandes/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/par_editeur', name: 'app_commandes_par_editeur')]
    public function parEditeur(CommandesRepository $commandesRepo,EntityManagerInterface $entityManager): Response
    {
    //    $commandes = $commandesRepo->findBy([], ['Editeur' => 'ASC']);
    //    return $this->render('commandes/par_editeur.html.twig', [
    //     'commandes' => $commandes
    //    ]);
        $query = $entityManager->createQuery(
            'SELECT DISTINCT c
            FROM App\Entity\Commandes c
            JOIN c.livres l
            ORDER BY l.Editeur ASC'
        );

        $commandes = $query->getResult();

        return $this->render('commandes/par_editeur.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/par_fournisseur', name: 'app_commandes_par_fournisseur')]
    public function parFournisseur(CommandesRepository $commandesRepo,EntityManagerInterface $entityManager): Response
    {
    //    $commandes = $commandesRepo->findBy([], ['fournisseur' => 'ASC']);
    //    return $this->render('commandes/par_fournisseur.html.twig', [
    //     'commandes' => $commandes
    //    ]);
        $query = $entityManager->createQuery(
            'SELECT DISTINCT c
            FROM App\Entity\Commandes c
            JOIN c.fournisseur f
            ORDER BY f.Raison_sociale ASC'
        );

        $commandes = $query->getResult();

        return $this->render('commandes/par_fournisseur.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/par_date', name:'app_commandes_par_date')]
    public function parDate(CommandesRepository $commandesRepo)
    {
        // $commandes = $commandesRepo->findBy([], ['Date_achat' => 'ASC']);

        $commandes = $commandesRepo->findDistinctDate();
        return $this->render('commandes/par_date.html.twig', [
            'commandes' => $commandes
        ]);
    }
}
