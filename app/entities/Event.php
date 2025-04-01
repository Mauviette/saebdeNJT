<?php
class Article {

    public function __construct(private ?int $id,
                            private ?string $title,
                            private ?string $content,
                            private ?string $place,
                            ) {

                            }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
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

    public function getDatePublication(): ?string {
        return $this->date_publication;
    }

    public function setDatePublication(?string $date_publication): void {
        $this->date_publication = $date_publication;
    }
}
?>
