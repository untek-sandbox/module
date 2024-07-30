<?php

namespace Untek\Sandbox\Module\Modules\Workout\Application\Commands;

use Untek\Core\Enum\Helpers\EnumHelper;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\Device;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\PuncakeSuite;

class GenerateTableCommand
{

    public function __construct(
        private Device $device,
        private PuncakeSuite $suite,
        private int $puncakeCount,
    )
    {
    }

    public function getDevice(): Device
    {
        return $this->device;
    }

    public function getSuite(): PuncakeSuite
    {
        return $this->suite;
    }

    public function getPuncakeCount(): int
    {
        return $this->puncakeCount;
    }
}
