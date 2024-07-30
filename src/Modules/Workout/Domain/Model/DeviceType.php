<?php

namespace Untek\Sandbox\Module\Modules\Workout\Domain\Model;

use Untek\Core\Enum\Helpers\EnumHelper;

class DeviceType
{

    /** гантель */
    const DUMBBELL = 'dumbbell';

    /** штанга */
    const BARBELL = 'barbell';

    public function __construct(
        private string $value,
    )
    {
        EnumHelper::validate(self::class, $value);
    }

    public function get(): mixed
    {
        return $this->value;
    }
}
