DROP TABLE IF EXISTS Participe CASCADE;
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
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom TEXT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    fond DECIMAL(15,2) DEFAULT 0,
    role ENUM('admin', 'utilisateur') NOT NULL,
    date_adhesion DATE NOT NULL
);

CREATE TABLE Evenements (
    id_evenement INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(50) NOT NULL,
    description TEXT,
    lieu VARCHAR(255) NOT NULL,
    prix DECIMAL(15,2) NOT NULL,
    date_evenement DATE NOT NULL
);

CREATE TABLE Commande (
    id_commande INT PRIMARY KEY AUTO_INCREMENT,
    prix INT NOT NULL,
    quantite INT NOT NULL
);

CREATE TABLE Produits (
    id_produit INT PRIMARY KEY AUTO_INCREMENT,
    nom_Prod VARCHAR(25) NOT NULL,
    Description VARCHAR(1000),
    Prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE Articles (
    id_article INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATETIME NOT NULL
);

CREATE TABLE Commentaires (
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    contenu VARCHAR(50) NOT NULL
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
