<?php
class Purchase
{

    public function __construct(private ?int $id, private Article $article, private ?User $user, private int $quantity)
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): Article
    {
        $this->article = $article;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): Void
    {
        $this->User = $user;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void 
    {
        $this->quantity = $quantity;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): void
    {
        $this->date = $date;
    }
}
?>
