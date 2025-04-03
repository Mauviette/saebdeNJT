<?php

require_once './app/core/Repository.php';
require_once './app/entities/Comment.php';
require_once './app/repositories/UserRepository.php';
class CommentRepository
{
	private $pdo;

	public function __construct()
	{
		$this->pdo = Repository::getInstance()->getPDO();
	}

	public function findAll(): array {
		$userRepository = new UserRepository();
		$query = "SELECT * FROM Commentaire";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$commentaires = [];
		foreach ($results as $row) {
			$commentaires[] = new Comment(
				$row['id_commentaire'],
				$row['id_utilisateur'],
				$userRepository->getUserById($row['id_utilisateur'])->getNom(),
				$row['id_evenement'],
				$row['contenu'],
				new \DateTime($row['date_publication'])
			);
		}

		return $commentaires;
	}

	public function getCommentaireById(int $id_commentaire): ?Comment
	{
		$userRepository = new UserRepository();
		$query = "SELECT * FROM Commentaire WHERE id_commentaire = :id_commentaire";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(':id_commentaire', $id_commentaire, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row) {
			return new Comment(
				$row['id_commentaire'],
				$row['id_utilisateur'],
				$userRepository->getUserById($row['id_utilisateur'])->getNom(),
				$row['id_evenement'],
				$row['contenu'],
				new \DateTime($row['date_publication'])
			);
		}

		return null;
	}

	public function findAllByEventId(int $id_evenement): array
	{
		$userRepository = new UserRepository();
		$query = "SELECT * FROM Commentaire WHERE id_evenement = :id_evenement";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(':id_evenement', $id_evenement, PDO::PARAM_INT);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$commentaires = [];
		foreach ($results as $row) {
			$commentaires[] = new Comment(
				$row['id_commentaire'],
				$row['id_utilisateur'],
				$userRepository->getUserById($row['id_utilisateur'])->getNom(),
				$row['id_evenement'],
				$row['contenu'],
				new \DateTime($row['date_publication'])
			);
		}

		return $commentaires;
	}

	public function createCommentaire(int $id_utilisateur, int $id_evenement, String $contenu): bool
	{
		$stmt = $this->pdo->prepare('
			INSERT INTO Commentaire (id_utilisateur, id_evenement, contenu) 
			VALUES (:id_utilisateur, :id_evenement, :contenu)
		');
		return $stmt->execute([
			'id_utilisateur' => $id_utilisateur,
			'id_evenement' => $id_evenement,
			'contenu' => $contenu
		]);
	}

	public function updateCommentaire(int $id_commentaire, String $contenu): bool
	{
		$stmt = $this->pdo->prepare('
			UPDATE Commentaire 
			SET contenu = :contenu 
			WHERE id_commentaire = :id_commentaire
		');
		return $stmt->execute([
			'id_commentaire' => $id_commentaire,
			'contenu' => $contenu
		]);
	}

	public function deleteCommentaire(int $id_commentaire): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Commentaire WHERE id_commentaire = :id_commentaire');
		return $stmt->execute(['id_commentaire' => $id_commentaire]);
	}
}
