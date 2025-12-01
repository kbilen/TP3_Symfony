<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\JeuVideo;
use App\Entity\Utilisateur;
use App\Repository\GenreRepository;
use App\Repository\JeuVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/jeu_video', name: 'api_jeu_video_index', methods: ['GET'])]
    public function listJeuVideo(JeuVideoRepository $jeuVideoRepository): JsonResponse
    {
        $jeuVideos = $jeuVideoRepository->findAll();
        $data = [];

        foreach ($jeuVideos as $jeuVideo) {
            $data[] = [
                'id' => $jeuVideo->getId(),
                'titre' => $jeuVideo->getTitre(),
                'developpeur' => $jeuVideo->getDeveloppeur(),
                'date_sortie' => $jeuVideo->getDateSortie()?->format('Y-m-d'),
                'prix' => $jeuVideo->getPrix(),
                'description' => $jeuVideo->getDescription(),
                'image_url' => $jeuVideo->getImageUrl(),
                'editeur' => $jeuVideo->getEditeur()->getNom(),
                'genre' => $jeuVideo->getGenre()?->getNom(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/jeu_video/{id}', name: 'api_jeu_video_show', methods: ['GET'])]
    public function showJeuVideo(JeuVideo $jeuVideo): JsonResponse
    {
        $data = [
            'id' => $jeuVideo->getId(),
            'titre' => $jeuVideo->getTitre(),
            'developpeur' => $jeuVideo->getDeveloppeur(),
            'date_sortie' => $jeuVideo->getDateSortie()?->format('Y-m-d'),
            'prix' => $jeuVideo->getPrix(),
            'description' => $jeuVideo->getDescription(),
            'image_url' => $jeuVideo->getImageUrl(),
            'editeur' => $jeuVideo->getEditeur()->getNom(),
            'genre' => $jeuVideo->getGenre()?->getNom(),
        ];

        return $this->json($data);
    }

    #[Route('/genre', name: 'api_genre_index', methods: ['GET'])]
    public function listGenre(GenreRepository $genreRepository): JsonResponse
    {
        $genres = $genreRepository->findAll();
        $data = [];

        foreach ($genres as $genre) {
            $data[] = [
                'id' => $genre->getId(),
                'nom' => $genre->getNom(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/genre/{id}', name: 'api_genre_show', methods: ['GET'])]
    public function showGenre(Genre $genre): JsonResponse
    {
        $data = [
            'id' => $genre->getId(),
            'nom' => $genre->getNom(),
        ];

        return $this->json($data);
    }

    #[Route('/utilisateur/{id}/collection', name: 'api_user_collection', methods: ['GET'])]
    public function userCollection(Utilisateur $utilisateur): JsonResponse
    {
        $collects = $utilisateur->getCollects();
        $data = [];

        foreach ($collects as $collect) {
            $jeuVideo = $collect->getJeuvideo();
            $data[] = [
                'id' => $jeuVideo->getId(),
                'titre' => $jeuVideo->getTitre(),
                'statut' => $collect->getStatut()->value, // Assuming Enum has value
                'date_achat' => $collect->getDateAchat()?->format('Y-m-d'),
                'prix_achat' => $collect->getPrixAchat(),
                'commentaire' => $collect->getCommentaire(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/genre/{id}', name: 'api_genre_delete', methods: ['DELETE'])]
    public function deleteGenre(Genre $genre, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($genre);
        $entityManager->flush();

        return $this->json(['message' => 'Genre supprimé avec succès'], Response::HTTP_OK);
    }

    #[Route('/ping', name: 'api_ping', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('pong', Response::HTTP_OK);
    }

    #[Route('/healthcheck', name: 'api_healthcheck', methods: ['GET'])]
    public function healthcheck(EntityManagerInterface $entityManager): JsonResponse
    {
        $status = [
            'api' => 'ok',
            'database' => 'unknown',
        ];

        try {
            $entityManager->getConnection()->connect();
            $status['database'] = 'ok';
        } catch (\Exception $e) {
            $status['database'] = 'error';
            $status['database_error'] = $e->getMessage();
        }

        return $this->json($status);
    }
}
