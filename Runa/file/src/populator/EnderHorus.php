<?php

namespace pocketmine\level\generator\ender\populator;

use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\utils\Random;
use pocketmine\event\player\PlayerDeathEvent;

class EnderHorus extends Populator{
    /** @var ChunkManager */
    private $level;
    private $randomAmount;
    private $baseAmount;

    public function setRandomAmount($amount){
        $this->randomAmount = $amount;
    }

    public function setBaseAmount($amount){
        $this->baseAmount = $amount;
    }

    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random){
        if (mt_rand(0, 100) < 10) {
            $this->level = $level;
            $amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
            for ($i = 0; $i < $amount; ++$i) {
                $x = $random->nextRange($chunkX * 16, $chunkX * 16 + 15);
                $z = $random->nextRange($chunkZ * 16, $chunkZ * 16 + 15);
                $y = $this->getHighestWorkableBlock($x, $z);
                if ($this->level->getBlockIdAt($x, $y, $z) == Block::END_STONE){
                    $height = 8;
                    for ($ny = $y; $ny < $y + $height; $ny++){
                            $nd = 8 / (1 * pi());
                            for ($d = 0; $d < 8; $d += $nd){
                                $level->setBlockIdAt($x + (cos(deg2rad($d) - 1)), $ny, $z + (sin(deg2rad($d) - 1)), 240);
                                $level->setBlockIdAt($x + (cos(deg2rad($d) - 1)), $ny + 1, $z + (sin(deg2rad($d) - 1)), 200);

                                $level->setBlockIdAt($x + 1, $y + 5, $z, 240);
                                $level->setBlockIdAt($x + 2, $y + 5, $z, 240);
                                $level->setBlockIdAt($x + 2, $y + 6, $z, 200);

                                $level->setBlockIdAt($x - 1, $y + 6, $z, 240);
                                $level->setBlockIdAt($x - 2, $y + 6, $z, 240);
                                $level->setBlockIdAt($x - 2, $y + 7, $z, 200);

                                $level->setBlockIdAt($x, $y + 3, $z + 1, 240);
                                $level->setBlockIdAt($x, $y + 3, $z + 2, 240);
                                $level->setBlockIdAt($x, $y + 4, $z + 2, 200);

                                $level->setBlockIdAt($x, $y + 4, $z - 1, 240);
                                $level->setBlockIdAt($x, $y + 4, $z - 2, 240);
                                $level->setBlockIdAt($x, $y + 5, $z - 2, 200);
                            }
                        }
                    }
                }
            }
        }


    private function getHighestWorkableBlock($x, $z){
        for($y = 127; $y >= 0; --$y){
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b == Block::END_STONE) {
                break;
            }
        }
        return $y === 0 ? -1 : $y;
    }
}
?>