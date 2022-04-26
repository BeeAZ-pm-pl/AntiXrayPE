<?php

declare(strict_types=1);

namespace BeeAZZ\AntiXrayPE;

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
			if ($this->anti[$sender->getName()]) {
				$this->anti[$sender->getName()] = false;
				$sender->sendMessage(TextFormat::colorize($this->cfg->get("offMsg", "Xray check mode is now on!")));
			} else {
				$this->anti[$sender->getName()] = true;
				$sender->sendMessage(TextFormat::colorize($this->cfg->get("onMsg", "Xray check mode is now off!")));
			}
			return true;
		}
		return false;
	}

	private function onWarning($staff, $player, $event): void {
		foreach ($this->getServer()->getOnlinePlayers() as $staff) {
			if ($staff->hasPermission("antixraype.check")) {
				if ($this->anti[$staff->getName()]) {
					$staff->sendMessage(TextFormat::colorize(str_replace(
						["{prefix}", "{name}", "{block}"],
						[$this->cfg->get("prefix", "&l&e[AntiXrayPE]"), $player->getName(), $event->getBlock()],
						$this->cfg->get("warningMsg", "{prefix} ➳ &aPlayer &c{name} &abreak &c{block}")
					)));
				}
			}
		}
		return;
	}

	public function onBreak(BlockBreakEvent $event) {
		$block = $event->getBlock();
		$player = $event->getPlayer();
		if ($this->cfg->get("CoalOre", true)) {
			if ($block->isSameType(VanillaBlocks::COAL_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("RedstoneOre", true)) {
			if ($block->isSameType(VanillaBlocks::REDSTONE_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("DiamondOre", true)) {
			if ($block->isSameType(VanillaBlocks::DIAMOND_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("LapisLazuliOre", true)) {
			if ($block->isSameType(VanillaBlocks::LAPIS_LAZULI_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("IronOre", true)) {
			if ($block->isSameType(VanillaBlocks::IRON_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("GoldOre", true)) {
			if ($block->isSameType(VanillaBlocks::GOLD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("EmeraldOre", true)) {
			if ($block->isSameType(VanillaBlocks::EMERALD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
	}
}
