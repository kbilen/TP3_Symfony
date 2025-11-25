<?php

namespace App\DataFixtures;

use App\Entity\Collect;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\JeuVideo;
use App\Entity\Utilisateur;
use App\Enum\StatutJeuEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --- GENRES ---
        $genres = [];
        $genreNames = [
            'ACTION' => 'Jeux d\'action',
            'AVENTURE' => 'Jeux d\'aventure',
            'RPG' => 'Jeux de rôle',
            'STRATEGIE' => 'Jeux de stratégie',
            'SPORT' => 'Jeux de sport',
            'COURSE' => 'Jeux de course',
        ];

        foreach ($genreNames as $nom => $desc) {
            $genre = new Genre();
            $genre->setNom($nom);
            $genre->setDescription($desc);
            $genre->setActif(true);
            $manager->persist($genre);
            $genres[] = $genre;
        }

        // --- EDITEURS ---
        $editeurs = [];
        $editeurData = [
            ['Sony', 'Japon', 'https://www.sie.com'],
            ['Nintendo', 'Japon', 'https://www.nintendo.com'],
            ['Microsoft', 'USA', 'https://www.xbox.com'],
            ['Ubisoft', 'France', 'https://www.ubisoft.com'],
            ['EA', 'USA', 'https://www.ea.com'],
            ['Capcom', 'Japon', 'https://www.capcom.com'],
            ['Sega', 'Japon', 'https://www.sega.com'],
        ];

        foreach ($editeurData as $data) {
            $editeur = new Editeur();
            $editeur->setNom($data[0]);
            $editeur->setPays($data[1]);
            $editeur->setSiteWeb($data[2]);
            $editeur->setDescription("Description de l'éditeur " . $data[0]);
            $manager->persist($editeur);
            $editeurs[] = $editeur;
        }

        // --- JEUX VIDEO ---
        $jeux = [];
        $titres = [
            'The Last of Us', 'God of War', 'Zelda Breath of the Wild', 'Elden Ring', 'FIFA 24',
            'Call of Duty', 'Minecraft', 'GTA V', 'Cyberpunk 2077', 'Hollow Knight',
            'Hades', 'Celeste', 'Super Mario Odyssey', 'Red Dead Redemption 2', 'Witcher 3',
            'Portal 2', 'Half-Life 2', 'Overwatch 2', 'Valorant', 'League of Legends'
        ];

        // --- JEUX VIDEO ---
        $jeux = [];
        $jeuxData = [
            'The Last of Us' => 'https://upload.wikimedia.org/wikipedia/en/4/46/Video_Game_Cover_-_The_Last_of_Us.jpg',
            'God of War' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/God_of_War_4_cover.jpg',
            'Zelda Breath of the Wild' => 'https://upload.wikimedia.org/wikipedia/en/c/c6/The_Legend_of_Zelda_Breath_of_the_Wild.jpg',
            'Elden Ring' => 'https://upload.wikimedia.org/wikipedia/en/b/b9/Elden_Ring_Box_art.jpg',
            'FIFA 24' => 'https://upload.wikimedia.org/wikipedia/en/b/b9/EA_Sports_FC_24_cover.jpg',
            'Call of Duty' => 'https://upload.wikimedia.org/wikipedia/en/1/1f/Call_of_Duty_Modern_Warfare_%282019%29_cover.jpg',
            'Minecraft' => 'https://upload.wikimedia.org/wikipedia/en/5/51/Minecraft_cover.png',
            'GTA V' => 'https://upload.wikimedia.org/wikipedia/en/a/a5/Grand_Theft_Auto_V.png',
            'Cyberpunk 2077' => 'https://upload.wikimedia.org/wikipedia/en/9/9f/Cyberpunk_2077_box_art.jpg',
            'Hollow Knight' => 'https://upload.wikimedia.org/wikipedia/en/0/04/Hollow_Knight_first_cover_art.webp',
            'Hades' => 'https://upload.wikimedia.org/wikipedia/en/c/cc/Hades_cover_art.jpg',
            'Celeste' => 'https://upload.wikimedia.org/wikipedia/en/b/bc/Celeste_box_art.png',
            'Super Mario Odyssey' => 'https://upload.wikimedia.org/wikipedia/en/8/8d/Super_Mario_Odyssey.jpg',
            'Red Dead Redemption 2' => 'https://upload.wikimedia.org/wikipedia/en/4/44/Red_Dead_Redemption_II.jpg',
            'Witcher 3' => 'https://upload.wikimedia.org/wikipedia/en/0/0c/Witcher_3_cover_art.jpg',
            'Portal 2' => 'https://upload.wikimedia.org/wikipedia/en/f/f9/Portal2cover.jpg',
            'Half-Life 2' => 'https://upload.wikimedia.org/wikipedia/en/2/25/Half-Life_2_cover.jpg',
            'Overwatch 2' => 'https://upload.wikimedia.org/wikipedia/en/5/51/Overwatch_2_cover_art.jpg',
            'Valorant' => 'https://upload.wikimedia.org/wikipedia/en/f/f6/Valorant_cover_art.jpg',
            'League of Legends' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d8/League_of_Legends_2019_vector.svg/1200px-League_of_Legends_2019_vector.svg.png'
        ];

        $uploadDir = __DIR__ . '/../../public/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($jeuxData as $titre => $url) {
            $jeu = new JeuVideo();
            $jeu->setTitre($titre);
            $jeu->setDeveloppeur('Studio ' . mt_rand(1, 10));
            $jeu->setDateSortie(new \DateTime('-' . mt_rand(1, 3650) . ' days'));
            $jeu->setPrix(mt_rand(1000, 8000) / 100);
            $jeu->setDescription("Description du jeu " . $titre);
            $jeu->setEditeur($editeurs[array_rand($editeurs)]);
            $jeu->setGenre($genres[array_rand($genres)]);

            // Download image
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            if (str_contains($extension, '?')) {
                $extension = explode('?', $extension)[0];
            }
            if (!$extension) $extension = 'jpg';
            
            $filename = strtolower(str_replace([' ', ':', "'", '(', ')'], '-', $titre)) . '.' . $extension;
            $filepath = $uploadDir . '/' . $filename;

            // Simple download (suppress errors if offline/fails)
            try {
                if (!file_exists($filepath)) {
                    // Use a user agent to avoid 403 from Wikipedia
                    $context = stream_context_create([
                        'http' => [
                            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
                        ]
                    ]);
                    $content = @file_get_contents($url, false, $context);
                    if ($content) {
                        file_put_contents($filepath, $content);
                    }
                }
                if (file_exists($filepath)) {
                    $jeu->setImageUrl('/uploads/' . $filename);
                }
            } catch (\Exception $e) {
                // Ignore download errors
            }

            $manager->persist($jeu);
            $jeux[] = $jeu;
        }

        // --- UTILISATEURS ---
        $utilisateurs = [];
        $userNames = [
            ['Jean', 'Dupont', 'jdupont'],
            ['Marie', 'Curie', 'mcurie'],
            ['Pierre', 'Martin', 'pmartin'],
            ['Sophie', 'Durand', 'sdurand'],
            ['Lucas', 'Bernard', 'lbernard'],
            ['Emma', 'Petit', 'epetit'],
        ];

        foreach ($userNames as $data) {
            $user = new Utilisateur();
            $user->setPrenom($data[0]);
            $user->setNom($data[1]);
            $user->setPseudo($data[2]);
            $user->setMail(strtolower($data[2]) . '@example.com');
            $user->setDateNaissance(new \DateTime('-' . mt_rand(6000, 15000) . ' days'));
            $manager->persist($user);
            $utilisateurs[] = $user;
        }

        // --- COLLECTIONS ---
        $statuts = StatutJeuEnum::cases();

        // 4 utilisateurs avec > 5 jeux
        for ($i = 0; $i < 4; $i++) {
            $user = $utilisateurs[$i];
            $nbJeux = mt_rand(6, 12);
            
            // Shuffle games to pick unique ones
            shuffle($jeux);
            
            for ($j = 0; $j < $nbJeux; $j++) {
                $collect = new Collect();
                $collect->setUtilisateur($user);
                $collect->setJeuvideo($jeux[$j]);
                $collect->setStatut($statuts[array_rand($statuts)]);
                $collect->setDateModifStatut(new \DateTime('-' . mt_rand(1, 365) . ' days'));
                
                if (mt_rand(0, 1)) {
                    $collect->setPrixAchat(mt_rand(500, 6000) / 100);
                    $collect->setDateAchat(new \DateTime('-' . mt_rand(365, 730) . ' days'));
                }
                
                if (mt_rand(0, 1)) {
                    $collect->setCommentaire("Commentaire sur le jeu " . $jeux[$j]->getTitre());
                }

                $manager->persist($collect);
            }
        }

        // 1 utilisateur avec quelques jeux (1-3)
        $user = $utilisateurs[4];
        shuffle($jeux);
        for ($j = 0; $j < 2; $j++) {
            $collect = new Collect();
            $collect->setUtilisateur($user);
            $collect->setJeuvideo($jeux[$j]);
            $collect->setStatut(StatutJeuEnum::POSSEDE);
            $collect->setDateModifStatut(new \DateTime());
            $manager->persist($collect);
        }

        // Le dernier utilisateur (index 5) n'a pas de jeux (0 collections)

        $manager->flush();
    }
}
