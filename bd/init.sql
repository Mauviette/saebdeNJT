DROP TABLE IF EXISTS Participe CASCADE;
DROP TABLE IF EXISTS Articles CASCADE;
DROP TABLE IF EXISTS Demande CASCADE;
DROP TABLE IF EXISTS A_Pour_Produit CASCADE;
DROP TABLE IF EXISTS Poste CASCADE;
DROP TABLE IF EXISTS Envoie CASCADE;
DROP TABLE IF EXISTS Est_Envoye_Sur CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Evenements CASCADE;
DROP TABLE IF EXISTS Commande CASCADE;
DROP TABLE IF EXISTS Commentaire CASCADE;
DROP TABLE IF EXISTS Produits CASCADE;
DROP TABLE IF EXISTS Contact CASCADE;

CREATE TABLE Utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    nom TEXT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    fond DECIMAL(15,2) DEFAULT 0,
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'utilisateur_adherent', 'utilisateur')),
    date_adhesion DATE NOT NULL,
    parametre_notification VARCHAR(20) NOT NULL CHECK (parametre_notification IN ('tous', 'articles', 'evenements', 'none')) DEFAULT 'tous'
);

CREATE TABLE Evenements (
    id_evenement SERIAL PRIMARY KEY,
    titre VARCHAR(50) NOT NULL,
    description TEXT,
    lieu VARCHAR(255) NOT NULL,
    prix DECIMAL(15,2) NOT NULL,
    date_evenement DATE NOT NULL
);

CREATE TABLE Commande (
    id_commande SERIAL PRIMARY KEY,
    prix INT NOT NULL,
    quantite INT NOT NULL
);

CREATE TABLE Produits (
    id_produit SERIAL PRIMARY KEY,
    nom_prod VARCHAR(25) NOT NULL,
    description VARCHAR(1000),
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    category VARCHAR(50) NOT NULL CHECK (category IN ('Vetements', 'Goodies','Accessoires', 'Bagagerie'))
);

CREATE TABLE Articles (
    id_article SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE
);


CREATE TABLE Contact (
    id_contact SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE
);

CREATE TABLE Commentaire (
    id_commentaire SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_evenement INT NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_evenement) REFERENCES Evenements(id_evenement) ON DELETE CASCADE
);



-- Relations

CREATE TABLE Participe (
    id_utilisateur INT,
    id_evenement INT,
    PRIMARY KEY (id_utilisateur, id_evenement),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_evenement) REFERENCES Evenements(id_evenement) ON DELETE CASCADE
);

CREATE TABLE Demande (
    id_utilisateur INT,
    id_commande INT,
    PRIMARY KEY (id_utilisateur, id_commande),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_commande) REFERENCES Commande(id_commande) ON DELETE CASCADE
);

CREATE TABLE A_Pour_Produit (
    id_commande INT,
    id_produit INT,
    PRIMARY KEY (id_commande, id_produit),
    FOREIGN KEY (id_commande) REFERENCES Commande(id_commande) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES Produits(id_produit) ON DELETE CASCADE
);

CREATE TABLE Poste (
    id_utilisateur INT,
    id_article INT,
    PRIMARY KEY (id_utilisateur, id_article),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_article) REFERENCES Articles(id_article) ON DELETE CASCADE
);

CREATE TABLE Envoie (
    id_utilisateur INT,
    id_commentaire INT,
    PRIMARY KEY (id_utilisateur, id_commentaire),
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_commentaire) REFERENCES Commentaires(id_commentaire) ON DELETE CASCADE
);

CREATE TABLE Est_Envoye_Sur (
    id_commentaire INT,
    id_evenement INT,
    PRIMARY KEY (id_commentaire, id_evenement),
    FOREIGN KEY (id_commentaire) REFERENCES Commentaires(id_commentaire) ON DELETE CASCADE,
    FOREIGN KEY (id_evenement) REFERENCES Evenements(id_evenement) ON DELETE CASCADE
);



-- Exemples de données
INSERT INTO Utilisateur (nom, email, mot_de_passe, fond, role, date_adhesion) VALUES
('Jean Dupont', 'jean.dupont@example.com', 'password123', 100.00, 'utilisateur', '2025-01-01'),
('Marie Curie', 'marie.curie@example.com', 'securepass456', 200.00, 'utilisateur_adherent', '2025-02-15'),
('Albert Einstein', 'albert.einstein@example.com', 'relativity789', 300.00, 'admin', '2025-03-10');

INSERT INTO Articles (id_utilisateur, titre, contenu, date_publication) VALUES
(1,'Découverte d''une nouvelle exoplanète', 'Les astronomes ont découvert une exoplanète potentiellement habitable à 12 années-lumière de la Terre.', '2025-01-15 10:30:00'),
(1,'Avancée majeure dans la lutte contre le cancer', 'Des chercheurs ont mis au point un traitement révolutionnaire qui réduit les tumeurs de 80% en quelques semaines.', '2025-02-20 14:45:00'),
(2,'Lancement d''une voiture électrique révolutionnaire', 'Une startup a dévoilé une voiture électrique avec une autonomie de 1000 km et une recharge en 5 minutes.', '2025-03-10 09:15:00'),
(3,'Record mondial de vitesse en avion', 'Un avion expérimental a battu le record de vitesse en atteignant Mach 10.', '2025-04-05 16:00:00'),
(1,'Découverte d''une cité perdue', 'Des archéologues ont découvert une cité perdue datant de 3000 ans dans la jungle amazonienne.', '2025-05-12 11:20:00'),
(2,'Progrès dans l''intelligence artificielle', 'Une nouvelle IA est capable de composer des symphonies dignes des plus grands compositeurs.', '2025-06-18 13:50:00'),
(1,'Mission réussie sur Mars', 'Un rover a découvert des traces d''eau liquide sur Mars, relançant les espoirs de trouver de la vie.', '2025-07-22 08:40:00'),
(3,'Invention d''un matériau ultra-résistant', 'Des scientifiques ont créé un matériau 10 fois plus résistant que l''acier et 5 fois plus léger.', '2025-08-30 17:25:00'),
(3,'Découverte d''une nouvelle espèce marine', 'Une expédition sous-marine a révélé une espèce de poisson bioluminescent inconnue jusqu''à présent.', '2025-09-14 19:10:00'),
(3,'Progrès dans l''intelligence artificielle', 'Une nouvelle IA est capable de composer des symphonies dignes des plus grands compositeurs.', '2025-10-01 12:05:00');

INSERT INTO Evenements (titre, description, lieu, prix, date_evenement) VALUES
('Soirée Laser Game', 'Une soirée amusante de laser game entre amis.', 'Laser Game Arena, Paris', 20.00, '2025-11-15'),
('Bowling Night', 'Participez à une soirée bowling avec des prix à gagner.', 'Bowling Center, Lyon', 15.00, '2025-11-20'),
('Escape Game Challenge', 'Résolvez des énigmes pour vous échapper en équipe.', 'Escape Room, Marseille', 25.00, '2025-12-05'),
('Tournoi de Karting', 'Compétition de karting avec des trophées pour les gagnants.', 'Karting Club, Toulouse', 30.00, '2025-12-10'),
('Soirée Cinéma en Plein Air', 'Projection de films sous les étoiles.', 'Parc Central, Bordeaux', 10.00, '2025-11-25'),
('Atelier de Cuisine', 'Apprenez à cuisiner des plats délicieux avec un chef.', 'Cuisine Studio, Lille', 50.00, '2025-12-01'),
('Randonnée en Montagne', 'Une journée de randonnée avec des guides expérimentés.', 'Alpes, Grenoble', 0.00, '2025-11-18'),
('Soirée Jeux de Société', 'Une soirée conviviale autour de jeux de société.', 'Café Ludique, Nantes', 5.00, '2025-11-22'),
('Cours de Yoga en Plein Air', 'Séance de yoga pour tous les niveaux.', 'Plage de Nice', 10.00, '2025-11-30'),
('Concert de Musique Live', 'Un concert avec des artistes locaux.', 'Salle de Concert, Strasbourg', 25.00, '2025-12-15'),
('Miaulement de groupe', 'Miaou.', 'Salle de Concert, Strasbourg', 25.00, '2025-04-12'),
('Anniversaire de Jules', 'Miaou.', 'Salle de Concert, Strasbourg', 25.00, '2025-03-12');


INSERT INTO Produits (nom_prod, description, prix, stock, category) VALUES
('T-shirt', 'T-shirt en coton bio', 15.00, 100, 'Vetements'),
('Mug', 'Mug en céramique', 10.00, 50, 'Goodies'),
('Sweatshirt', 'Sweatshirt en polaire', 30.00, 75, 'Vetements'),
('Casquette', 'Casquette en tissu respirant', 12.00, 60, 'Accessoires'),
('Sac à dos', 'Sac à dos en toile robuste', 40.00, 30, 'Bagagerie'),
('Bouteille Isotherme', 'Bouteille en acier inoxydable', 20.00, 80, 'Goodies'),
('Porte-clés', 'Porte-clés en métal gravé', 5.00, 150, 'Goodies'),
('Écharpe', 'Écharpe en laine douce', 25.00, 40, 'Accessoires'),
('Valise Cabine', 'Valise cabine légère et robuste', 60.00, 20, 'Bagagerie');

INSERT INTO Contact (id_utilisateur, sujet, contenu) VALUES
(1, 'Problème de connexion', 'Je n’arrive pas à me connecter à mon compte. Pouvez-vous m’aider ?'),
(2, 'Demande d’information', 'Pouvez-vous m’en dire plus sur les événements à venir ?'),
(3, 'Suggestion', 'Je suggère d’ajouter un nouveau produit dans la boutique.');

INSERT INTO Commentaire (id_utilisateur, id_evenement, contenu) VALUES
(1, 1, 'Super soirée, j’ai adoré le laser game !'),
(2, 1, 'C’était vraiment amusant, à refaire !'),
(3, 2, 'Le bowling était génial, merci pour l’organisation.'),
(1, 2, 'J’ai passé une excellente soirée, bravo à l’équipe.'),
(2, 3, 'L’escape game était très bien conçu, un vrai défi !'),
(3, 3, 'Une expérience incroyable, je recommande à tout le monde.'),
(1, 4, 'Le karting était super, j’ai adoré la compétition.'),
(2, 4, 'Une journée mémorable, merci pour cet événement.'),
(3, 5, 'Le cinéma en plein air était magique, une belle ambiance.'),
(1, 5, 'J’ai adoré les films projetés, très bon choix.'),
(2, 6, 'L’atelier de cuisine était très instructif, merci au chef.'),
(3, 6, 'J’ai appris beaucoup de choses, une expérience enrichissante.'),
(1, 7, 'La randonnée était magnifique, les paysages étaient à couper le souffle.'),
(2, 7, 'Merci aux guides pour leur professionnalisme, une belle journée.'),
(3, 8, 'Une soirée conviviale, j’ai découvert de nouveaux jeux.'),
(1, 8, 'Merci pour cette soirée, c’était très amusant.'),
(2, 9, 'Le cours de yoga était relaxant, une belle expérience.'),
(3, 9, 'Merci pour cette séance, je me sens revigoré.'),
(1, 10, 'Le concert était incroyable, les artistes étaient talentueux.'),
(2, 10, 'Une soirée mémorable, merci pour l’organisation.'),
(3, 11, 'Miaou miaou miaou, une soirée inoubliable !'),
(1, 11, 'Miaou miaou, j’ai adoré cet événement.'),
(2, 12, 'Joyeux anniversaire Jules, une belle fête !'),
(3, 12, 'Merci pour cette soirée, c’était très réussi !');
