<?php
namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Editeur;
use App\Entity\JeuVideo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des genres de jeux vidéo
        $genres = [];

        $genreAction = new Genre();
        $genreAction->setNom('ACTION');
        $genreAction->setDescription('Jeux d\'action : jeux de plateforme, combat, tir (FPS, TPS, …)');
        $manager->persist($genreAction);
        $genreAction->setActif(true);
        $genreAction->setCreatedAt(new \DateTimeImmutable());
        $genreAction->setUpdateAt(new \DateTimeImmutable());
        $genres['ACTION'] = $genreAction;

        $genreAventure = new Genre();
        $genreAventure->setNom('AVENTURE');
        $genreAventure->setDescription('Jeux d\'aventure narrative, point and click…');
        $manager->persist($genreAventure);
        $genreAventure->setActif(true);
        $genreAventure->setCreatedAt(new \DateTimeImmutable());
        $genreAventure->setUpdateAt(new \DateTimeImmutable());
        $genres['AVENTURE'] = $genreAventure;

        $genreActionAventure = new Genre();
        $genreActionAventure->setNom('ACTION_AVENTURE');
        $genreActionAventure->setDescription('Infiltration, survival, …');
        $manager->persist($genreActionAventure);
        $genreActionAventure->setActif(true);
        $genreActionAventure->setCreatedAt(new \DateTimeImmutable());
        $genreActionAventure->setUpdateAt(new \DateTimeImmutable());;
        $genres['ACTION_AVENTURE'] = $genreActionAventure;

        $genreRpg = new Genre();
        $genreRpg->setNom('RPG');
        $genreRpg->setDescription('Jeux de rôle, MMORPG, …');
        $manager->persist($genreRpg);
        $genreRpg->setActif(true);
        $genreRpg->setCreatedAt(new \DateTimeImmutable());
        $genreRpg->setUpdateAt(new \DateTimeImmutable());
        $genres['RPG'] = $genreRpg;

        $genreStrategie = new Genre();
        $genreStrategie->setNom('STRATEGIE');
        $genreStrategie->setDescription('Jeux de stratégie (RTS, turn-based)');
        $manager->persist($genreStrategie);
        $genreStrategie->setActif(true);
        $genreStrategie->setCreatedAt(new \DateTimeImmutable());
        $genreStrategie->setUpdateAt(new \DateTimeImmutable());
        $genres['STRATEGIE'] = $genreStrategie;

        $genreSimulation = new Genre();
        $genreSimulation->setNom('SIMULATION');
        $genreSimulation->setDescription('Jeux de simulation, de gestion');
        $manager->persist($genreSimulation);
        $genreSimulation->setActif(false);
        $genreSimulation->setCreatedAt(new \DateTimeImmutable());
        $genreSimulation->setUpdateAt(new \DateTimeImmutable());
        $genres['SIMULATION'] = $genreSimulation;

        $genreSport = new Genre();
        $genreSport->setNom('SPORT');
        $genreSport->setDescription('Jeux de sport');
        $manager->persist($genreSport);
        $genreSport->setActif(true);
        $genreSport->setCreatedAt(new \DateTimeImmutable());
        $genreSport->setUpdateAt(new \DateTimeImmutable());
        $genres['SPORT'] = $genreSport;

        $genreCourse = new Genre();
        $genreCourse->setNom('COURSE');
        $genreCourse->setDescription('Jeux de course par ex. automobile');
        $manager->persist($genreCourse);
        $genreCourse->setActif(true);
        $genreCourse->setCreatedAt(new \DateTimeImmutable());
        $genreCourse->setUpdateAt(new \DateTimeImmutable());
        $genres['COURSE'] = $genreCourse;

        $genreReflexion = new Genre();
        $genreReflexion->setNom('REFLEXION');
        $genreReflexion->setDescription('Jeux de réflexion, puzzles, casse-tête');
        $manager->persist($genreReflexion);
        $genreReflexion->setActif(true);
        $genreReflexion->setCreatedAt(new \DateTimeImmutable());
        $genreReflexion->setUpdateAt(new \DateTimeImmutable());
        $genres['REFLEXION'] = $genreReflexion;

        // Création des éditeurs
        $editeurSony = new Editeur();
        $editeurSony->setNom('Sony Interactive Entertainment');
        $editeurSony->setPays('Japon');
        $editeurSony->setSiteWeb('https://www.sie.com');
        $editeurSony->setCreatedAt(new \DateTimeImmutable());
        $editeurSony->setUpdateAt(new \DateTimeImmutable());
        $manager->persist($editeurSony);

        $editeurNintendo = new Editeur();
        $editeurNintendo->setNom('Nintendo');
        $editeurNintendo->setPays('Japon');
        $editeurNintendo->setSiteWeb('https://www.nintendo.com');
        $editeurNintendo->setCreatedAt(new \DateTimeImmutable());
        $editeurNintendo->setUpdateAt(new \DateTimeImmutable());
        $manager->persist($editeurNintendo);

        $editeurMicrosoft = new Editeur();
        $editeurMicrosoft->setNom('Xbox Game Studios');
        $editeurMicrosoft->setPays('États-Unis');
        $editeurMicrosoft->setSiteWeb('https://www.xbox.com/games');
        $editeurMicrosoft->setCreatedAt(new \DateTimeImmutable());
        $editeurMicrosoft->setUpdateAt(new \DateTimeImmutable());
        $manager->persist($editeurMicrosoft);

        $editeurUbisoft = new Editeur();
        $editeurUbisoft->setNom('Ubisoft');
        $editeurUbisoft->setPays('France');
        $editeurUbisoft->setSiteWeb('https://www.ubisoft.com');
        $editeurUbisoft->setCreatedAt(new \DateTimeImmutable());
        $editeurUbisoft->setUpdateAt(new \DateTimeImmutable());
        $manager->persist($editeurUbisoft);

        // Création de jeux vidéo variés
        $jeu1 = new JeuVideo();
        $jeu1->setTitre('The Last of Us Part II');
        $jeu1->setEditeur($editeurSony);
        $jeu1->setGenre($genres['ACTION_AVENTURE']);
        $jeu1->setDeveloppeur('Naughty Dog');
        $jeu1->setDateSortie(new \DateTime('2020-06-19'));
        $jeu1->setPrix(59.99);
        $manager->persist($jeu1);

        $jeu2 = new JeuVideo();
        $jeu2->setTitre('The Legend of Zelda: Breath of the Wild');
        $jeu2->setEditeur($editeurNintendo);
        $jeu2->setGenre($genres['ACTION_AVENTURE']);
        $jeu2->setDeveloppeur('Nintendo EPD');
        $jeu2->setDateSortie(new \DateTime('2017-03-03'));
        $jeu2->setPrix(69.99);
        $manager->persist($jeu2);

        $jeu3 = new JeuVideo();
        $jeu3->setTitre('Elden Ring');
        $jeu3->setEditeur($editeurMicrosoft);
        $jeu3->setGenre($genres['RPG']);
        $jeu3->setDeveloppeur('FromSoftware');
        $jeu3->setDateSortie(new \DateTime('2022-02-25'));
        $jeu3->setPrix(59.99);
        $manager->persist($jeu3);

        $jeu4 = new JeuVideo();
        $jeu4->setTitre('Assassin\'s Creed Valhalla');
        $jeu4->setEditeur($editeurUbisoft);
        $jeu4->setGenre($genres['ACTION_AVENTURE']);
        $jeu4->setDeveloppeur('Ubisoft Montreal');
        $jeu4->setDateSortie(new \DateTime('2020-11-10'));
        $jeu4->setPrix(49.99);
        $manager->persist($jeu4);

        $jeu5 = new JeuVideo();
        $jeu5->setTitre('FIFA 24');
        $jeu5->setEditeur($editeurMicrosoft);
        $jeu5->setGenre($genres['SPORT']);
        $jeu5->setDeveloppeur('EA Sports');
        $jeu5->setDateSortie(new \DateTime('2023-09-29'));
        $jeu5->setPrix(69.99);
        $manager->persist($jeu5);

        $jeu6 = new JeuVideo();
        $jeu6->setTitre('Gran Turismo 7');
        $jeu6->setEditeur($editeurSony);
        $jeu6->setGenre($genres['COURSE']);
        $jeu6->setDeveloppeur('Polyphony Digital');
        $jeu6->setDateSortie(new \DateTime('2022-03-04'));
        $jeu6->setPrix(59.99);
        $manager->persist($jeu6);

        $jeu7 = new JeuVideo();
        $jeu7->setTitre('Portal 2');
        $jeu7->setEditeur($editeurMicrosoft);
        $jeu7->setGenre($genres['REFLEXION']);
        $jeu7->setDeveloppeur('Valve');
        $jeu7->setDateSortie(new \DateTime('2011-04-19'));
        $jeu7->setPrix(19.99);
        $manager->persist($jeu7);

        $jeu8 = new JeuVideo();
        $jeu8->setTitre('The Sims 4');
        $jeu8->setEditeur($editeurMicrosoft);
        $jeu8->setGenre($genres['SIMULATION']);
        $jeu8->setDeveloppeur('Maxis');
        $jeu8->setDateSortie(new \DateTime('2014-09-02'));
        $jeu8->setPrix(39.99);
        $manager->persist($jeu8);

        // Enregistrement en base de données
        $manager->flush();
    }
}
