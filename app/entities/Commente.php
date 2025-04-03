<?php
class Commentaire {

	public function __construct(
		public ?int $id_commentaire,
		private int $id_utilisateur,
		private int $id_evenement,
		private string $contenu,
		private ?\DateTime $date_publication = null
	) {}

	public function getIdCommentaire(): ?int {
		return $this->id_commentaire;
	}

	public function setIdCommentaire(?int $id_commentaire): void {
		$this->id_commentaire = $id_commentaire;
	}

	public function getIdUtilisateur(): int {
		return $this->id_utilisateur;
	}

	public function setIdUtilisateur(int $id_utilisateur): void {
		$this->id_utilisateur = $id_utilisateur;
	}

	public function getIdEvenement(): int {
		return $this->id_evenement;
	}

	public function setIdEvenement(int $id_evenement): void {
		$this->id_evenement = $id_evenement;
	}

	public function getContenu(): string {
		return $this->contenu;
	}

	public function setContenu(string $contenu): void {
		$this->contenu = $contenu;
	}

	public function getDatePublication(): ?\DateTime {
		return $this->date_publication;
	}

	public function setDatePublication(?\DateTime $date_publication): void {
		$this->date_publication = $date_publication;
	}
}
?>
