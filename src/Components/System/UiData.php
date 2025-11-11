<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\System;

class UiData implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return ['ui_data' => []];
    }
}