<?php
require_once './app/core/Repository.php';
require_once './app/entities/Contact.php';

class ContactRepository
{
	private $pdo;

	public function __construct()
	{
		$this->pdo = Repository::getInstance()->getPDO();
	}

	public function findAll(): array {
		$query = "SELECT * FROM Contact";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$contacts = [];
		foreach ($results as $row) {
			$contacts[] = new Contact(
				$row['id_contact'],
				$row['id_utilisateur'],
				$row['sujet'],
				$row['contenu'],
				new \DateTime($row['date_creation'])
			);
		}

		return $contacts;
	}

	public function getContactById(int $id_contact): ?Contact
	{
		$query = "SELECT * FROM Contact WHERE id_contact = :id_contact";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(':id_contact', $id_contact, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row) {
			return new Contact(
				$row['id_contact'],
				$row['id_utilisateur'],
				$row['sujet'],
				$row['contenu'],
				new \DateTime($row['date_creation'])
			);
		}

		return null;
	}

	public function createContact(int $id_utilisateur, String $sujet, String $contenu, DateTime $date_creation): bool
	{
		$stmt = $this->pdo->prepare('
			INSERT INTO Contact (id_utilisateur, sujet, contenu, date_creation) 
			VALUES (:id_utilisateur, :sujet, :contenu, :date_creation)
		');
		return $stmt->execute([
			'id_utilisateur' => $id_utilisateur,
			'sujet' => $sujet,
			'contenu' => $contenu,
			'date_creation' => $date_creation->format('Y-m-d')
		]);
	}

	public function updateContact(int $id_contact, int $id_utilisateur, String $sujet, String $contenu): bool
	{
		$stmt = $this->pdo->prepare('
			UPDATE Contact 
			SET id_utilisateur = :id_utilisateur, sujet = :sujet, contenu = :contenu 
			WHERE id_contact = :id_contact
		');
		return $stmt->execute([
			'id_contact' => $id_contact,
			'id_utilisateur' => $id_utilisateur,
			'sujet' => $sujet,
			'contenu' => $contenu
		]);
	}

	public function deleteContact(int $id_contact): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Contact WHERE id_contact = :id_contact');
		return $stmt->execute(['id_contact' => $id_contact]);
	}
}