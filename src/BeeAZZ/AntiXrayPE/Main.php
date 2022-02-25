<?php

namespace BeeAZZ\AntiXrayPE;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener{
  
  public function onEnable(): void{
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->saveDefaultConfig();
  }
  public function onBreak(BlockBreakEvent $event){
   $block = $event->getBlock();
   $player = $event->getPlayer();
  if($this->getConfig()->get("Coal") == true){
  if($block instanceof CoalOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
  }
}
}
  if($this->getConfig()->get("Iron") == true){
  if($block instanceof IronOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
  }
}
}
    }
  }
}
  if($this->getConfig()->get("Diamond") == true){
  if($block instanceof DiamondOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
  }
  }
  if($this->getConfig()->get("Lapis") == true){
  if($block instanceof LapisOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("[AntiXrayPE] ➳ Player ".$player->getName(). " break ".$event->getBlock());
     }
    }
  }
  }
  if($this->getConfig()->get("Emerald") == true){
  if($block instanceof EmeraldOre){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("[AntiXrayPE] ➳ Player ".$player->getName(). " break ".$event->getBlock());
     }
    }
  }
  }