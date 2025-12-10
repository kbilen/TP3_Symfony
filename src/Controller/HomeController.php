<?php

namespace App\Controller;

use App\Repository\JeuVideoRepository;
use App\Repository\EditeurRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        JeuVideoRepository $jeuVideoRepository,
        EditeurRepository $editeurRepository,
        GenreRepository $genreRepository
    ): Response {
        // Récupérer les statistiques
        $totalJeux = count($jeuVideoRepository->findAll());
        $totalEditeurs = count($editeurRepository->findAll());
        $totalGenres = count($genreRepository->findAll());
        
        // Récupérer les 6 derniers jeux ajoutés
        $derniersJeux = $jeuVideoRepository->findBy([], ['createdAt' => 'DESC'], 6);
        
        return $this->render('home/index.html.twig', [
            'totalJeux' => $totalJeux,
            'totalEditeurs' => $totalEditeurs,
            'totalGenres' => $totalGenres,
            'derniersJeux' => $derniersJeux,
        ]);
    }
}
