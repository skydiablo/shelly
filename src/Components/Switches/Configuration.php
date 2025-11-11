<?php

declare(strict_types=1);

namespace SkyDiablo\Shelly\Components\Switches;

use SkyDiablo\Shelly\Utils\ArrayUtils;

class Configuration implements ConfigurationInterface
{

    /**
     * The configuration of the Switch component contains information about the input mode, the timers, and the protection settings of the chosen switch instance. To Get/Set the configuration of the Switch component its id must be specified.
     *
     * @param int               $id                       Id of the Switch component instance
     * @param string|null       $name                     Name of the switch instance
     * @param InMode|null       $inMode                   Mode of the associated input. Range of values: momentary, follow, flip, detached, cycle (if applicable), activate (if applicable)
     * @param bool|null         $inLocked                 If True, all changes to physical inputs are ignored, regardless of mode.
     * @param InitialState|null $initialState             Output state to set on power_on. Range of values: off, on, restore_last, match_input
     * @param bool|null         $autoOn                   True if the "Automatic ON" function is enabled, false otherwise
     * @param int|null          $autoOnDelay              Seconds to pass until the component is switched back on
     * @param bool|null         $autoOff                  True if the "Automatic OFF" function is enabled, false otherwise
     * @param int|null          $autoOffDelay             Seconds to pass until the component is switched back off
     * @param bool|null         $autoRecoverVoltageErrors True if switch output state should be restored after over/undervoltage error is cleared, false otherwise (shown if applicable)
     * @param int|null          $inputId                  Id of the Input component which controls the Switch. Applicable only to Pro1 and Pro1PM devices. Valid values: 0, 1
     * @param int|null          $powerLimit               Limit (in Watts) over which overpower condition occurs (shown if applicable)
     * @param int|null          $voltageLimit             Limit (in Volts) over which overvoltage condition occurs (shown if applicable)
     * @param int|null          $undervoltageLimit        Limit (in Volts) under which undervoltage condition occurs (shown if applicable)
     * @param int|null          $currentLimit             Number, limit (in Amperes) over which overcurrent condition occurs (shown if applicable)
     * @param bool|null         $reverse                  Reverse measurement direction of active power and energy. setting the reverse option requires restart (shown if applicable)
     */
    public function __construct(
        protected int $id,
        protected ?string $name = null,
        protected ?InMode $inMode = null,
        protected ?bool $inLocked = null,
        protected ?InitialState $initialState = null,
        protected ?bool $autoOn = null,
        protected ?int $autoOnDelay = null,
        protected ?bool $autoOff = null,
        protected ?int $autoOffDelay = null,
        protected ?bool $autoRecoverVoltageErrors = null,
        protected ?int $inputId = null,
        protected ?int $powerLimit = null,
        protected ?int $voltageLimit = null,
        protected ?int $undervoltageLimit = null,
        protected ?int $currentLimit = null,
        protected ?bool $reverse = null,
    ) {}


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return ArrayUtils::arrayFilterNull([
            'id'                         => $this->id,
            'name'                       => $this->name,
            'in_mode'                    => $this->inMode,
            'in_locked'                  => $this->inLocked,
            'initial_state'              => $this->initialState,
            'auto_on'                    => $this->autoOn,
            'auto_on_delay'              => $this->autoOnDelay,
            'auto_off'                   => $this->autoOff,
            'auto_off_delay'             => $this->autoOffDelay,
            'autorecover_voltage_errors' => $this->autoRecoverVoltageErrors,
            'input_id'                   => $this->inputId,
            'power_limit'                => $this->powerLimit,
            'voltage_limit'              => $this->voltageLimit,
            'undervoltage_limit'         => $this->undervoltageLimit,
            'current_limit'              => $this->currentLimit,
            'reverse'                    => $this->reverse,
        ]);
    }
}