<?php

namespace Runa;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase as Base;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\entity\{Effect, Entity};
use pocketmine\scheduler\CallbackTask;
use pocketmine\level\Level;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class Main extends Base implements Listener{

	const PREFIX = "§l§7[:§eＭ§7:] - §f";
	const HELP = "Покупка рун§7:\n§7/§eruna buy {Названия} §7- §fПокупка рун§7,\n§7/§eruna buy ender §7- §fТелепортация в эндер мир§7,\n§7/§eruna buy nether §7- §fТелепортация в нижний мир§7,\n§7/§eruna buy speed §7- §fСкорость - Быстрое передвижение§7,\n§7/§eruna buy sila §7- §fСила - добавляет больше силы игроку§7,\n§7/§eruna buy regen §7- §fРегенерация - Восстановление жизней§7,";

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "onEffectFix")), 1);
		/*Работает как проверка и как цвет для текста*/
		$this->color = rand(3,6);
		/*Работает как проверка и как цвет для текста*/
	if($this->getServer()->getPluginManager()->getPlugin("Economy")){
		$this->money = $this->getServer()->getPluginManager()->getPlugin("Economy");
	}else{
	  	$this->getLogger()->error("Нет плагина на экономику текущий плагин был выключен");
	  	$this->getServer()->getPluginManager()->disablePlugins();
	  }
	}

    /*Fix багов для эндер мира и ада*/
	public function onRespawnFix(PlayerRespawnEvent $event){
	   if($event->getPlayer()->getName() == "ender"){
			$event->getPlayer()->teleport($this->getServer()->getLevelByName("world")->getSafeSpawn());
		}elseif($event->getPlayer()->getLevel()->getName() == "nether"){
			$event->getPlayer()->teleport($this->getServer()->getLevelByName("world")->getSafeSpawn());
		}elseif($event->getPlayer()->getLevel()->getName() == "world"){
			$event->getPlayer()->teleport($this->getServer()->getLevelByName("world")->getSafeSpawn());
		}
	}

	public function onEffectFix(){
	  foreach($this->getServer()->getOnlinePlayers() as $player){
		if($player->getLevel()->getName() == "world"){
	    	$player->addEffect(Effect::getEffect(16)->setDuration(9999*9999*16)->setVisible(false));
	    }elseif($player->getLevel()->getName() == "ender"){
	    	$player->removeEffect(16);
	    }elseif($player->getLevel()->getName() == "nether"){
	    	$player->removeEffect(16);
	    }
	  }
    }
    /*Fix багов для эндер мира и ада*/

    public function onTap(PlayerInteractEvent $event){
    	if($event->getBlock()->getId() == 0){
    		if($event->getPlayer()->getInventory()->getItemInHand()->getId() == 421){
    			if($event->getPlayer()->getItemInHand()->getName() == "§l§". $this->color ."Руна регенераций §7- §f30§7сек§r"){
    				$event->getPlayer()->addEffect(Effect::getEffect(10)->setAmplifier(1)->setDuration(10 * 180)->setVisible(false));
    				$event->getPlayer()->getInventory()->removeItem(Item::get(421,0));
    				$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");
    		    }
    	    }
    	}

    	if($event->getBlock()->getId() == 0){
    		if($event->getPlayer()->getInventory()->getItemInHand()->getId() == 421){
    			if($event->getPlayer()->getItemInHand()->getName() == "§l§". $this->color ."Руна силы §7- §f3§7м§r"){
    				$event->getPlayer()->addEffect(Effect::getEffect(5)->setAmplifier(1)->setDuration(10 * 180)->setVisible(false));
    				$event->getPlayer()->getInventory()->removeItem(Item::get(421,0));
    				$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");
    		    }
    	    }
    	}

    	if($event->getBlock()->getId() == 0){
    		if($event->getPlayer()->getInventory()->getItemInHand()->getId() == 421){
    			if($event->getPlayer()->getItemInHand()->getName() == "§l§". $this->color ."Руна скорости §7- §f5§7м§r"){
    				$event->getPlayer()->addEffect(Effect::getEffect(1)->setAmplifier(1)->setDuration(10 * 480)->setVisible(false));
    				$event->getPlayer()->getInventory()->removeItem(Item::get(421,0));
    				$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");
    		    }
    	    }
    	}

    	if($event->getBlock()->getId() == 0){
    	  if($event->getPlayer()->getInventory()->getItemInHand()->getId() == 421){
    		if($event->getPlayer()->getItemInHand()->getName() == "§l§". $this->color ."Руна энда §7- x§f2§r"){
    			if($this->getServer()->isLevelGenerated("ender")){
    			  if($event->getPlayer()->getLevel()->getName() == "ender"){
    				$event->getPlayer()->teleport($this->getServer()->getLevelByName("world")->getSafeSpawn());
    				$event->getPlayer()->getInventory()->removeItem(Item::get(421,0));
    				$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");
    		    }else{
    			  	$event->getPlayer()->teleport($this->getServer()->getLevelByName("ender")->getSafeSpawn());
    			    $event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");}
    			}else{
        	    	$event->getPlayer()->sendMessage(Main::PREFIX ."§fИзвините но мы не смогли найти данное измерение или же этот мир отключён§7: §e/runa§7,");}
        	    }
        	}
        }

        if($event->getBlock()->getId() == 0){
        	if($event->getPlayer()->getInventory()->getItemInHand()->getId() == 421){
        		if($event->getPlayer()->getItemInHand()->getName() == "§l§". $this->color ."Руна незера §7- x§f2§r"){
        			if($this->getServer()->isLevelGenerated("nether")){
        		if($event->getPlayer()->getLevel()->getName() == "nether"){
        			$event->getPlayer()->teleport($this->getServer()->getLevelByName("world")->getSafeSpawn());
        			$event->getPlayer()->getInventory()->removeItem(Item::get(421,0));
        			$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");
        		}else{
        			$event->getPlayer()->teleport($this->getServer()->getLevelByName("nether")->getSafeSpawn());
        			$event->getPlayer()->sendPopup("§l§fВы успешно использовали руну§7,");}
        		}else{
        	    	$event->getPlayer()->sendMessage(Main::PREFIX ."§fИзвините но мы не смогли найти данное измерение или же этот мир отключён§7: §e/runa§7,");}
        	    }
        	}
        }
    }

	public function onCommand(CommandSender $player, Command $command, $label, array $args){
		if($command->getName() == "runa"){
			if($player instanceof Player){
				if(isset($args[0])){
					if($args[0] == "buy"){
					  if(isset($args[1])){
						if($args[1] == "ender"){
						  if($this->money->myMoney($player->getName()) >= 150){
						  	$item = Item::get(421,0);
							$item->setCustomName("§l§". $this->color ."Руна энда §7- x§f2§r");
							$player->getInventory()->addItem($item);
							$player->sendPopup("§l§fВы успешно приобрели руну§7,");
							$this->money->reduceMoney($player->getName(), 150);
						  }else{
						  	$player->sendMessage(Main::PREFIX ."§fУ вас недостаточно денег§7, §fдля покупки§7, §fнужно §e150m");
						  }
						}elseif($args[1] == "nether"){
						  if($this->money->myMoney($player->getName()) >= 250){
						  	$item = Item::get(421,0);
						   	$item->setCustomName("§l§". $this->color ."Руна незера §7- x§f2§r");
						   	$player->getInventory()->addItem($item);
						   	$player->sendPopup("§l§fВы успешно приобрели руну§7,");
						   	$this->money->reduceMoney($player->getName(), 250);
						  }else{
						  	$player->sendMessage(Main::PREFIX ."§fУ вас недостаточно денег§7, §fдля покупки§7, §fнужно §e250m");
						  }
						}elseif($args[1] == "speed"){
						  if($this->money->myMoney($player->getName()) >= 450){
							$item = Item::get(421,0);
						   	$item->setCustomName("§l§". $this->color ."Руна скорости §7- §f5§7м§r");
						   	$player->getInventory()->addItem($item);
							$player->sendPopup("§l§fВы успешно приобрели руну§7,");
							$this->money->reduceMoney($player->getName(), 450);
						  }else{
						  	$player->sendMessage(Main::PREFIX ."§fУ вас недостаточно денег§7, §fдля покупки§7, §fнужно §e450m");
						  }
						}elseif($args[1] == "sila"){
						  if($this->money->myMoney($player->getName()) >= 750){
							$item = Item::get(421,0);
						   	$item->setCustomName("§l§". $this->color ."Руна силы §7- §f3§7м§r");
						   	$player->getInventory()->addItem($item);
							$player->sendPopup("§l§fВы успешно приобрели руну§7,");
							$this->money->reduceMoney($player->getName(), 750);
						  }else{
						  	$player->sendMessage(Main::PREFIX ."§fУ вас недостаточно денег§7, §fдля покупки§7, §fнужно §e750m");
						  }
						}elseif($args[1] == "regen"){
						  if($this->money->myMoney($player->getName()) >= 950){
							$item = Item::get(421,0);
						   	$item->setCustomName("§l§". $this->color ."Руна регенераций §7- §f30§7сек§r");
						   	$player->getInventory()->addItem($item);
							$player->sendPopup("§l§fВы успешно приобрели руну§7,");
							$this->money->reduceMoney($player->getName(), 950);
						  }else{
						  	$player->sendMessage(Main::PREFIX ."§fУ вас недостаточно денег§7, §fдля покупки§7, §fнужно §e750m");
						  }
						}else{
							$player->sendMessage(Main::PREFIX ."§fИзвините§7, §fно вы неправильно ввели команду или произошла ошибка§7: §e/runa§7,");
						}
					}else{
						$player->sendMessage(Main::PREFIX ."§fИзвините но вы неправильно ввели команду§7: §e/runa buy §7[§fНазвания руны§7],");
					}
				  }
				}else{
				   $player->sendMessage(Main::PREFIX . Main::HELP);
				}
		/*Если нужно обычное перемещение по команде*//*
		if($args[1] == "ender" || "nether"){
			if($this->getServer()->isLevelGenerated($args[0])){
			$player->teleport($this->getServer()->getLevelByName($args[0])->getSafeSpawn());
			    }else{
        	$player->sendMessage("§l§7[:§eＭ§7:] - §fИзвините но мы не смогли найти данное измерение§7: §f/runa§7,");
        }
        */
        /*Если нужно обычное перемещение по команде*/
			}
		}else{
			$player->sendMessage(Main::PREFIX ."§fИспользуйте в игре§7,");
		}
	}
}

?>