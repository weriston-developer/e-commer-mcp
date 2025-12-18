<?php

namespace App\Domain\Produto;

class Produto
{
    public function __construct(
        public readonly int $id,
        public readonly string $urlImg,
        public readonly string $name,
        public readonly string $category,
        public readonly string $size,
        public readonly float $price,
        public readonly string $station,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'url_img' => $this->urlImg,
            'name' => $this->name,
            'category' => $this->category,
            'size' => $this->size,
            'price' => $this->price,
            'station' => $this->station,
        ];
    }
}
