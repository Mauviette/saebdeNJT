<?php
class Event {

    public function __construct(private ?int $id,
                            private ?array $users,
                            private ?string $title,
                            private ?string $content,
                            private ?string $place,
                            private ?\DateTime $date,
                            private ?float $price
                            ) {

                            }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUsers(): ?array {
        return $this->users;
    }

    public function setUsers(?array $users): void {
        $this->users = $users;
    }
    
    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(?string $content): void {
        $this->content = $content;
    }

    public function getPlace(): ?string {
        return $this->place;
    }

    public function setPlace(?string $place): void {
        $this->place = $place;
    }

    public function getDate(): ?\DateTime {
        return $this->date;
    }

    public function setDate(?\DateTime $date): void {
        $this->date = $date;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }


}
?>
