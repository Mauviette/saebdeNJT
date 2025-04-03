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

	public function getAllContacts(): array
	{
		$query = $this->pdo->query('SELECT * FROM Contact');
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getContactById(int $id_contact): ?array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Contact WHERE id_contact = :id_contact');
		$stmt->execute(['id_contact' => $id_contact]);
		$contact = $stmt->fetch(PDO::FETCH_ASSOC);
		return $contact ?: null;
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
			'date_creation' => $date_creation ?? date('Y-m-d H:i:s')
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