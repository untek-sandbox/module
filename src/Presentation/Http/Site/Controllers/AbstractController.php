<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Controllers;

abstract class AbstractController
{

    public static function title(): ?string
    {
        return null;
    }

    public static function isHidden(): bool
    {
        return false;
    }
}