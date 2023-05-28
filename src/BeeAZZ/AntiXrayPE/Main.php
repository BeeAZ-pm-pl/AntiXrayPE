<?php

declare(strict_types=1);

namespace BeeAZZ\AntiXrayPE;

use pocketmine\block\Block;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class Main extends PluginBase implements Listener {

	protected Config $cfg;

	private array $anti = [];

	private const VERSION = 1;

	private function checkVersion(): void {
		if ($this->cfg->get("version", false) !== self::VERSION) {
			$this->getLogger()->notice("Your configuration file is outdated, updating the config.yml...");
			$this->getLogger()->notice("The old configuration file can be found at config_old.yml");
			rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
			$this->saveDefaultConfig();
			$this->getConfig()->reload();
		}
	}

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->cfg = $this->getConfig();
		$this->checkVersion();
	}

	public function onJoin(PlayerJoinEvent $event) {
		$name = $event->getPlayer()->getName();
		$this->anti[$name] = false;
	}

	public function onQuit(PlayerQuitEvent $event) {
		unset($this->anti[$event->getPlayer()->getName()]);
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
		if ($cmd->getName() === "antixray") {
			if (!($sender instanceof Player)) {
				$sender->sendMessage(TextFormat::RED . "You can't use this command in the terminal");
				return true;
			}
			$mode = $this->anti[$sender->getName()] ? "off" : "on";
			$this->anti[$sender->getName()] = !$this->anti[$sender->getName()];
			$sender->sendMessage(TextFormat::colorize($this->cfg->get("{$mode}Msg", "Xray check mode is now {$mode}!")));
			return true;
		}
		return false;
	}

	private function onWarning(Player $player, Block $block): void {
		$ores = [
			"CoalOre" => VanillaBlocks::COAL_ORE(),
			"RedstoneOre" => VanillaBlocks::REDSTONE_ORE(),
			"DiamondOre" => VanillaBlocks::DIAMOND_ORE(),
			"LapisLazuliOre" => VanillaBlocks::LAPIS_LAZULI_ORE(),
			"IronOre" => VanillaBlocks::IRON_ORE(),
			"GoldOre" => VanillaBlocks::GOLD_ORE(),
			"EmeraldOre" => VanillaBlocks::EMERALD_ORE(),
		];
		foreach ($ores as $name => $ore) {
			if ($this->cfg->get($name, true) && $block->isSameState($ore)) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage(TextFormat::colorize(str_replace(
								["{prefix}", "{name}", "{block}"],
								[$this->cfg->get("prefix", "&l&e[AntiXrayPE]"), $player->getName(), $block],
								$this->cfg->get("warningMsg", "{prefix} ➳ &aPlayer &c{name} &abreak &c{block}")
							)));
						}
					}
				}
			}
		}
	}

	public function onBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$this->onWarning($player, $block);
	}
}