<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Wifi;

class Station1 extends Station
{
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        $sta = parent::jsonSerialize();

        return [
            'sta1' => $sta['sta'],
        ];
    }
}