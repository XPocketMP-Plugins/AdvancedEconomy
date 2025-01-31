<?php

declare(strict_types=1);

namespace AdvancedEconomy;

class InflationManager {
    private Main $plugin;
    private float $currentSupply = 0.0;
    private float $baseValue = 1.0;
    private float $maxSupply = 1000000.0;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function getCurrentSupply(): float {
        return $this->currentSupply;
    }

    public function setCurrentSupply(float $amount): void {
        $this->currentSupply = max(0, $amount);
    }

    public function getInflationRate(): float {
        if ($this->currentSupply <= 0) {
            return 0.0;
        }
    return ($this->baseValue * ($this->maxSupply / $this->currentSupply));
    }

    public function getCoinValue(): float {
        return $this->baseValue * ($this->maxSupply / $this->getCurrentSupply());
    }
}
