<?php
class Item {

    public function __construct(private ?int $id,
                            private ?string $name,
                            private ?string $description,
                            private ?float $price,
                            private ?int $quantity,
                            private ?string $category,
                            ) {

                            }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getName(): ?string {
        return $this->name;
    }
    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getQuantity(): ?int {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }

    public function getCategory(): ?string {
        return $this->category;
    }

    public function setCategory(?string $category): void {
        $this->category = $category;
    }
}
?>
