<?php

declare(strict_types=1);

namespace AdvancedEconomy;

class InflationManager {
    private Main $plugin;
    private float $baseValue = 1.0;
    private float $maxSupply = 1000000.0;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function getCurrentSupply(): float {
        $totalSupply = 0.0;
        foreach ($this->plugin->getEconomyManager()->getTopPlayers() as $balance) {
            $totalSupply += $balance;
        }
        return max(1, $totalSupply);
    }

    public function getCoinValue(): float {
        return $this->baseValue * ($this->maxSupply / $this->getCurrentSupply());
    }
}
