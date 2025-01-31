<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use pocketmine\event\Listener;
use AdvancedEconomy\Events\SellEvent;
use pocketmine\utils\TextFormat;

class SellListener implements Listener {

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onSell(SellEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $amount = $event->getAmount();
        $price = $event->getPrice();

        $player->sendMessage(TextFormat::GREEN . "You sold $amount " . $item->getName() . " for $price Aether Coins.");
    }
}
