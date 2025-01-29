<?php

declare(strict_types=1);

namespace AdvancedEconomy\Events;

use pocketmine\event\Event;
use pocketmine\player\Player;

class TransactionEvent extends Event {

    private Player $sender;
    private Player $receiver;
    private float $amount;

    public function __construct(Player $sender, Player $receiver, float $amount) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->amount = $amount;
    }

    /**
     * Get the player who is sending the coins.
     */
    public function getSender(): Player {
        return $this->sender;
    }

    /**
     * Get the player who is receiving the coins.
     */
    public function getReceiver(): Player {
        return $this->receiver;
    }

    /**
     * Get the amount of coins being transferred.
     */
    public function getAmount(): float {
        return $this->amount;
    }

    /**
     * Set the amount to be transferred.
     */
    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }
}
