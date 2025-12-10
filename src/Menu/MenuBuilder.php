<?php
namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private FactoryInterface $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Accueil', ['route' => 'app_home']);
        $menu->addChild('Jeux vidéo', ['route' => 'app_jeu_video_index']);
        $menu->addChild('Genres', ['route' => 'app_genre_index']);
        $menu->addChild('Éditeurs', ['route' => 'app_editeur_index']);
        $menu->addChild('Collections', ['route' => 'app_collection_index']);
        $menu->addChild('Utilisateurs', ['route' => 'app_utilisateur_index']);

        return $menu;
    }
}
