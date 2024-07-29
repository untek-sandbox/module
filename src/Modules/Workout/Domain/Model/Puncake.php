<?php

namespace Untek\Sandbox\Module\Modules\Workout\Domain\Model;

class Puncake
{

    public function __construct(
        // Вес
        private float $weight,
        // Ширина
        private float $width,
    )
    {
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getWidth(): float
    {
        return $this->width;
    }
}
