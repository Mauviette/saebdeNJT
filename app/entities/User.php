<?php
class User {
   
    public function __construct(private ?int $id,
                            private ?string $nom,
                            private ?float $fonds,
                            private ?string $role,
                            private ?\DateTime $date_adhesion) {}

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    public function getFonds(): ?float {
        return $this->fonds;
    }

    public function setFonds(?float $fonds): void {
        $this->fonds = $fonds;
    }

    public function getDatePublication(): ?\DateTime {
        return $this->date_publication;
    }

    public function setDatePublication(?\DateTime $date_publication): void {
        $this->date_publication = $date_publication;
    }

    public function getRole(): ?string {
        return $this->role;
    }

    public function setRole(?string $role): void {
        $this->role = $role;
    }

    public function getDateAdhesion(): ?\DateTime {
        return $this->date_adhesion;
    }

    public function setDateAdhesion(?\DateTime $date_adhesion): void {
        $this->date_adhesion = $date_adhesion;
    }

    public function serialize(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'fonds' => $this->fonds,
            'date_publication' => $this->date_publication,
            'role' => $this->role,
            'date_adhesion' => $this->date_adhesion,
        ];
    }

    public function unserialize(array $data): void {
        $this->id = $data['id'];
        $this->nom = $data['nom'];
        $this->fonds = $data['fonds'];
        $this->date_publication = $data['date_publication'];
        $this->role = $data['role'];
        $this->date_adhesion = $data['date_adhesion'];
    }
}
?>
