<?php

namespace BeeAZZ\AntiXrayPE;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;
use pocketmine\block\{CoalOre, RedstoneOre, DiamondOre, LapisOre, EmeraldOre};
use pocketmine\command\{Command, CommandSender};
use pocketmine\block\BlockLegacyIds as Ids;
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent};

class Main extends PluginBase implements Listener{
  
  protected $anti = [];
  
  protected const VERSION = 1;
  
  public function onEnable(): void{
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->saveDefaultConfig();
   if($this->getConfig()->get("version") !== self::VERSION or !$this->getConfig()->exists("version")){
   $this->getLogger()->notice("§c§lPlease Use config.yml Latest");
   $this->getServer()->getPluginManager()->disablePlugin($this);
   }
  }
  
  public function onJoin(PlayerJoinEvent $ev){
  $name = $ev->getPlayer()->getName();
  $this->anti[$name] = false;
  }
  
  public function onQuit(PlayerQuitEvent $ev){
  unset($this->anti[$ev->getPlayer()->getName()]);
  }
  
  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
   switch($cmd->getName()){
    case "antixray":
     if(!$sender instanceof Player){
     $sender->sendMessage("Please Use Command In Game");
     return true;
     }
     if($sender->hasPermission("antixraype.check")){
     if($this->anti[$sender->getName()] == true){
     $this->anti[$sender->getName()] = false;
     $sender->sendMessage($this->getConfig()->get("off"));
     }else{
     $this->anti[$sender->getName()] = true;
     $sender->sendMessage($this->getConfig()->get("on"));
     }
     break;
     }
    return true;
   }
return true;
  }
  
  public function onBreak(BlockBreakEvent $event){
   $block = $event->getBlock();
   $player = $event->getPlayer();
  if($this->getConfig()->get("Coal") == true){
  if($block instanceof CoalOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
  }
    }
}
}
  if($this->getConfig()->get("Redstone") == true){
  if($block instanceof RedstoneOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
       if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
  }
}
}
}
    }
  if($this->getConfig()->get("Diamond") == true){
  if($block instanceof DiamondOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
       if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
     }
    }
  }
  }
  if($this->getConfig()->get("Lapis") == true){
  if($block instanceof LapisOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
    }
  }
  }
  if($this->getConfig()->get("Iron") == true){
  if($block->getId() == Ids::IRON_ORE){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
    }
  }
  }
  if($this->getConfig()->get("Gold") == true){
  if($block->getId() == Ids::GOLD_ORE){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
    }
  }
  }
  if($this->getConfig()->get("Emerald") == true){
  if($block instanceof EmeraldOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      if($this->anti[$staff->getName()] == true){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
  }
  }
  }
}
}
