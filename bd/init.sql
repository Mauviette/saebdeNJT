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
DROP TABLE IF EXISTS Produits CASCADE;


CREATE TABLE Utilisateur (
    id_utilisateur SERIAL PRIMARY KEY,
    nom TEXT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    fond DECIMAL(15,2) DEFAULT 0,
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'utilisateur_adherent', 'utilisateur')),
    date_adhesion DATE NOT NULL
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
    nom_Prod VARCHAR(25) NOT NULL,
    Description VARCHAR(1000),
    Prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE Articles (
    id_article SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATE NOT NULL
);

CREATE TABLE Commentaires (
    id_commentaire SERIAL PRIMARY KEY,
    id_article INT NOT NULL,
    contenu TEXT NOT NULL,
    date_publication TIMESTAMP NOT NULL,
    FOREIGN KEY (id_article) REFERENCES Articles(id_article) ON DELETE CASCADE
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
INSERT INTO Articles (titre, contenu, date_publication) VALUES
('Découverte d''une nouvelle exoplanète', 'Les astronomes ont découvert une exoplanète potentiellement habitable à 12 années-lumière de la Terre.', '2025-01-15'),
('Avancée majeure dans la lutte contre le cancer', 'Des chercheurs ont mis au point un traitement révolutionnaire qui réduit les tumeurs de 80% en quelques semaines.', '2025-02-20'),
('Lancement d''une voiture électrique révolutionnaire', 'Une startup a dévoilé une voiture électrique avec une autonomie de 1000 km et une recharge en 5 minutes.', '2025-03-10'),
('Record mondial de vitesse en avion', 'Un avion expérimental a battu le record de vitesse en atteignant Mach 10.', '2025-04-05'),
('Découverte d''une cité perdue', 'Des archéologues ont découvert une cité perdue datant de 3000 ans dans la jungle amazonienne.', '2025-05-12'),
('Progrès dans l''intelligence artificielle', 'Une nouvelle IA est capable de composer des symphonies dignes des plus grands compositeurs.', '2025-06-18'),
('Mission réussie sur Mars', 'Un rover a découvert des traces d''eau liquide sur Mars, relançant les espoirs de trouver de la vie.', '2025-07-22'),
('Invention d''un matériau ultra-résistant', 'Des scientifiques ont créé un matériau 10 fois plus résistant que l''acier et 5 fois plus léger.', '2025-08-30'),
('Découverte d''une nouvelle espèce marine', 'Une expédition sous-marine a révélé une espèce de poisson bioluminescent inconnue jusqu''à présent.', '2025-09-14'),
('Progrès dans l''intelligence artificielle', 'Une nouvelle IA est capable de composer des symphonies dignes des plus grands compositeurs.', '2025-10-01');

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

INSERT INTO Utilisateur (nom, email, mot_de_passe, fond, role, date_adhesion) VALUES
('Jean Dupont', 'jean.dupont@example.com', 'password123', 100.00, 'utilisateur', '2025-01-01');