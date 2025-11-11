<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Utils;

class ArrayUtils
{

    public static function arrayFilterNull(array $array, array $keyExceptions = []): array
    {
        return array_filter($array, function ($value, $key) use ($keyExceptions) {
            return
                ($value !== null)
                || in_array($key, $keyExceptions);
        }, ARRAY_FILTER_USE_BOTH);
    }

}