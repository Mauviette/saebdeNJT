<?php
class Contact {

	public function __construct(
		public ?int $id,
		private int $id_utilisateur,
		private string $sujet,
		private string $contenu,
		private ?\DateTime $date_creation = null
	) {}

	public function getIdContact(): ?int {
		return $this->id;
	}

	public function setIdContact(?int $id): void {
		$this->id = $id;
	}

	public function getIdUtilisateur(): int {
		return $this->id_utilisateur;
	}

	public function setIdUtilisateur(int $id_utilisateur): void {
		$this->id_utilisateur = $id_utilisateur;
	}

	public function getSujet(): string {
		return $this->sujet;
	}

	public function setSujet(string $sujet): void {
		$this->sujet = $sujet;
	}

	public function getContenu(): string {
		return $this->contenu;
	}

	public function setContenu(string $contenu): void {
		$this->contenu = $contenu;
	}

	public function getDateCreation(): ?\DateTime {
		return $this->date_creation;
	}

	public function setDateCreation(?\DateTime $date_creation): void {
		$this->date_creation = $date_creation;
	}
}
?>
