<?php

declare(strict_types=1);

namespace AdvancedEconomy;

use AdvancedEconomy\Commands\{
    BalanceCommand, PayCommand, SetMoneyCommand, AddMoneyCommand, 
    TakeMoneyCommand, TopMoneyCommand, SellCommand, SellAllCommand, InflationCommand
};
use AdvancedEconomy\Listeners\{
    PlayerJoinListener, PlayerDeathListener, BlockBreakListener, 
    EntityKillListener, TransactionListener, SellListener
};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    private static Main $instance;
    private EconomyManager $economyManager;
    private InflationManager $inflationManager;

    public function onEnable(): void {
        self::$instance = $this;

        $this->economyManager = new EconomyManager($this);
        $this->inflationManager = new InflationManager($this);

        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();

        $this->getServer()->getCommandMap()->registerAll("AdvancedEconomy", [
            new BalanceCommand($this),
            new PayCommand($this),
            new SetMoneyCommand($this),
            new AddMoneyCommand($this),
            new TakeMoneyCommand($this),
            new TopMoneyCommand($this),
            new SellCommand($this),
            new SellAllCommand($this),
            new InflationCommand($this)
        ]);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoinListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerDeathListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreakListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new EntityKillListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new TransactionListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new SellListener($this), $this);

        $this->getLogger()->info("AdvancedEconomy has been enabled!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("AdvancedEconomy has been disabled!");
    }

    public static function getInstance(): Main {
        return self::$instance;
    }

    public function getEconomyManager(): EconomyManager {
        return $this->economyManager;
    }

    public function getInflationManager(): InflationManager {
        return $this->inflationManager;
    }
}
