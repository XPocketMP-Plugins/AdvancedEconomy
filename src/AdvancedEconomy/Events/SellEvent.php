<?php

declare(strict_types=1);

namespace AdvancedEconomy\Events;

use pocketmine\event\Event;
use pocketmine\player\Player;
use pocketmine\item\Item;

class SellEvent extends Event {

    private Player $player;
    private Item $item;
    private int $amount;
    private float $price;

    public function __construct(Player $player, Item $item, int $amount, float $price) {
        $this->player = $player;
        $this->item = $item;
        $this->amount = $amount;
        $this->price = $price;
    }

    public function getPlayer(): Player {
        return $this->player;
    }

    public function getItem(): Item {
        return $this->item;
    }

    public function getAmount(): int {
        return $this->amount;
    }

    public function getPrice(): float {
        return $this->price;
    }
}
