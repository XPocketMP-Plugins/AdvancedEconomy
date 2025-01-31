<?php

declare(strict_types=1);

namespace AdvancedEconomy;

use pocketmine\utils\Config;

class EconomyManager {
    private Main $plugin;
    private Config $balances;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->balances = new Config($plugin->getDataFolder() . "balances.yml", Config::YAML);
    }

    public function playerExists(string $playerName): bool {
        return $this->balances->exists($playerName);
    }

    public function getBalance(string $playerName): float {
        return (float) $this->balances->get($playerName, 100.0); // Default: 100 Aether Coins
    }

    public function setBalance(string $playerName, float $amount): void {
        $this->balances->set($playerName, max(0, round($amount, 2))); // Dibulatkan ke 2 desimal
        $this->balances->save();
    }

    public function addBalance(string $playerName, float $amount): void {
        $this->setBalance($playerName, $this->getBalance($playerName) + $amount);
    }

    public function takeBalance(string $playerName, float $amount): void {
        $this->setBalance($playerName, max(0, $this->getBalance($playerName) - $amount));
    }

    public function hasEnough(string $playerName, float $amount): bool {
        return $this->getBalance($playerName) >= $amount;
    }

    public function getTopPlayers(int $limit = 10): array {
        $allBalances = $this->balances->getAll();
        $allBalances = array_map('floatval', $allBalances); // Pastikan semua jadi float
        arsort($allBalances);
        return array_slice($allBalances, 0, $limit, true);
    }
}