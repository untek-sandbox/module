<?php

namespace Untek\Sandbox\Module\Modules\Workout\Domain\Model;

class PuncakeSuite
{

    private array $puncakeWidth;
    private array $puncakeSuite;

    public function add(float $weight, float $width, int $count): void
    {
        $weight = strval($weight);
        $this->puncakeWidth[$weight] = $width;
        $this->puncakeSuite[$weight] = $count;
    }

    public function getPuncakeWidth(): array
    {
        return $this->puncakeWidth;
    }

    public function getPuncakeSuite(): array
    {
        return $this->puncakeSuite;
    }
}
