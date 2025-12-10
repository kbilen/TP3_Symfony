<?php

namespace App\Controller;

use App\Repository\JeuVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Contrôleur de démonstration pour le TP9 - Gestion des erreurs
 * 
 * Ce contrôleur illustre la gestion des erreurs avec try/catch
 * conformément aux consignes du TP.
 */
class ErrorDemoController extends AbstractController
{
    public function __construct(
        private JeuVideoRepository $repository
    ) {}

    /**
     * TÂCHE 1: Méthode show avec gestion d'erreurs
     * 
     * Cette méthode démontre la gestion des erreurs selon le TP:
     * - try: recherche l'objet et lance NotFoundHttpException si non trouvé
     * - catch: ajoute un flash message et redirige
     */
    #[Route('/demo/jeu/{id}', name: 'app_demo_jeu_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        try {
            // Récupère l'objet via le repository
            $item = $this->repository->find($id);
            
            // Vérifie si l'objet existe
            if (!$item) {
                throw new NotFoundHttpException('Item non trouvé');
            }
            
            // Si trouvé, retourne la vue avec render
            return $this->render('jeu_video/show.html.twig', [
                'jeu_video' => $item,
            ]);
            
        } catch (\Exception $e) {
            // Ajoute un message flash
            $this->addFlash('error', 'Une erreur est survenue : ' . $e->getMessage());
            
            // Redirige l'utilisateur vers l'accueil
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * Route de test pour déclencher une erreur 404
     */
    #[Route('/demo/error/404', name: 'app_demo_error_404')]
    public function triggerError404(): Response
    {
        throw new NotFoundHttpException('Cette page n\'existe pas - Test 404');
    }

    /**
     * Route de test pour déclencher une erreur 403
     */
    #[Route('/demo/error/403', name: 'app_demo_error_403')]
    public function triggerError403(): Response
    {
        throw $this->createAccessDeniedException('Accès refusé - Test 403');
    }

    /**
     * Route de test pour déclencher une erreur 500
     */
    #[Route('/demo/error/500', name: 'app_demo_error_500')]
    public function triggerError500(): Response
    {
        throw new \Exception('Erreur serveur interne - Test 500');
    }
}
