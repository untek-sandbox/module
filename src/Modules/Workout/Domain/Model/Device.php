<?php

namespace Untek\Sandbox\Module\Modules\Workout\Domain\Model;

use Untek\Core\Enum\Helpers\EnumHelper;

class Device
{

    public function __construct(
        private string $type,
        private float $neckWidth,
        private float $barWeight,
    )
    {
        EnumHelper::validate(DeviceType::class, $type);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNeckWidth(): float
    {
        return $this->neckWidth;
    }

    public function getBarWeight(): float
    {
        return $this->barWeight;
    }
}
