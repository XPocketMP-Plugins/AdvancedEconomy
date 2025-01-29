<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use AdvancedEconomy\Main;
use AdvancedEconomy\Events\TransactionEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class TransactionListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onTransaction(TransactionEvent $event): void {
        $sender = $event->getSender();
        $receiver = $event->getReceiver();
        $amount = $event->getAmount();

        $tax = $amount * 0.02;
        $netAmount = $amount - $tax;

        $economy = $this->plugin->getEconomyManager();

        if ($economy->getBalance($sender->getName()) < $amount) {
            $sender->sendMessage(TextFormat::RED . "You do not have enough Aether Coin to complete this transaction.");
            $event->cancel();
            return;
        }

        $economy->takeBalance($sender->getName(), $amount);
        $economy->addBalance($receiver->getName(), $netAmount);

        $sender->sendMessage(TextFormat::YELLOW . "You paid " . TextFormat::AQUA . $receiver->getName() . TextFormat::YELLOW . " " . $netAmount . " AC (2% tax applied).");
        $receiver->sendMessage(TextFormat::GREEN . "You received " . TextFormat::YELLOW . "$netAmount AC" . TextFormat::GREEN . " from " . TextFormat::AQUA . $sender->getName());
    }
}
