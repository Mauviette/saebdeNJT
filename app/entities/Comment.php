<?php
class Comment {

    public function __construct(private ?int $id,
                            private User $user,
                            private Event $event,
                            private ?string $content,
                            private ?\DateTime $date,
                            ) {

                            }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setUser(?int $user): void {
        $this->user = $user;
    }

    public function getEvent(): Event {
        return $this->event;
    }

    public function setEvent(?int $event): void {
        $this->event = $event;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(?string $content): void {
        $this->content = $content;
    }

    public function getDatePublication(): ?\DateTime {
        return $this->date_publication;
    }

    public function setDatePublication(?\DateTime $date_publication): void {
        $this->date_publication = $date_publication;
    }
}
?>