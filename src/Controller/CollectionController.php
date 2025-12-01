<?php

namespace App\Controller;

use App\Entity\Collect;
use App\Entity\Utilisateur;
use App\Form\CollectType;
use App\Repository\CollectRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/collection')]
final class CollectionController extends AbstractController
{
    #[Route(name: 'app_collection_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        // List users with their collections count
        return $this->render('collection/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/user/{id}', name: 'app_collection_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('collection/show.html.twig', [
            'utilisateur' => $utilisateur,
            'collects' => $utilisateur->getCollects(),
        ]);
    }

    #[Route('/user/{id}/add', name: 'app_collection_add', methods: ['GET', 'POST'])]
    public function add(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $collect = new Collect();
        $collect->setUtilisateur($utilisateur);
        
        $form = $this->createForm(CollectType::class, $collect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update dateModifStatut automatically if needed, though constructor sets it
            $collect->setDateModifStatut(new \DateTime());
            
            $entityManager->persist($collect);
            $entityManager->flush();

            return $this->redirectToRoute('app_collection_show', ['id' => $utilisateur->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collection/new.html.twig', [
            'collect' => $collect,
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_collection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collect $collect, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollectType::class, $collect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update dateModifStatut if status changed (could be handled by listener, but simple here)
            // For now just update it on any edit or check change set
            $collect->setDateModifStatut(new \DateTime());
            
            $entityManager->flush();

            return $this->redirectToRoute('app_collection_show', ['id' => $collect->getUtilisateur()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collection/edit.html.twig', [
            'collect' => $collect,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_collection_delete', methods: ['POST'])]
    public function delete(Request $request, Collect $collect, EntityManagerInterface $entityManager): Response
    {
        $userId = $collect->getUtilisateur()->getId();
        
        if ($this->isCsrfTokenValid('delete'.$collect->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($collect);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collection_show', ['id' => $userId], Response::HTTP_SEE_OTHER);
    }
}
