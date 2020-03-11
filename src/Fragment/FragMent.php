<?php


namespace Fragment;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerInteractEvent;

class FragMent extends PluginBase implements Listener {

    private static $instance = null;

    public static function getInstance() {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable() {
      
	  @mkdir($this->getDataFolder());
		
        // @mkdir($this->getDataFolder() , 0777, true);
        $this->cfg = new Config($this->getDataFolder() . "Config.yml", CONFIG::YAML, array(
            "如果您有安装" => "Fancy团队底部插件的话",
            "如果您不想开启替换碎片" => "请把替换物品值改为0",
            "如果您有开启替换开关"=>"那么必须填写替换的物品名称",
            "碎片1" => "铁链胸甲左",
            "碎片2" => "铁链胸甲右",
            "碎片3" => "铁链胸甲上",
            "碎片4" => "铁链胸甲下",
            "碎片5" => "铁链晶石",
			"替换物品" => "0",
			"替换特殊值" => "0",
			"替换数量" => "1",
			"替换开关"=>"关",
			"全局开关"=>"开",
            "替换物品名称"=>""

        ));
		
		$this->date=new Config($this->getDataFolder()."Date.yml",Config::YAML,array());
		$this->xh=new Config($this->getDataFolder()."XiaoHao.yml",Config::YAML,array());
		
        $this->pl = new Config($this->getDataFolder() . "Player.yml", CONFIG::YAML, array(
            "玩家碎片大全" => "全在下面2333"
        ));
		
		
		
		
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->getLogger()->info("§b   =============§e繁星碎片§b============");
		$this->getLogger()->info("§b    作者:Magic雪飞 §6来自:Fancy团队");
        $this->getLogger()->info("§a本插件完全免费!已在GitHub开源,转载请注明");
		$this->getLogger()->info("§e插件版本1.0.2，已进行第二次更新 分别是以下");
	    $this->getLogger()->info("§7 更新了碎片5的几率和赠送奖励和新增召唤卡");
        $this->getLogger()->info("§b更新了其他插件可以获取的API 请前往Git查看");
        $this->getLogger()->info(" 极致插件 来自github.com/MagicBloodFLY");
    }
    public function onJoin(PlayerJoinEvent $e) {
		
		if($this->cfg->get("全局开关")=="关")
		{
			return;
		}
		
		
		$p=$e->getPlayer();
        $n = $p->getName();
		$date = date("Y-m-d");
	$cid=$p->getClientId();
	
	
        if (!$this->xh->exists($cid)) 
		{
			$this->xh->set($cid,$n);
			$this->xh->set($n,"0");
			 $this->xh->save();
		}
		else
		{
			echo "CID已注册 玩家名字 $n\n";
			
		}
		
		if($this->xh->get($cid)==$n)
		{
			//无发生
			
		}
		else
		{
			$this->xh->set($n,1);
			 $this->xh->save();
			
		}
		
		if($this->xh->get($n)>0)
		{
			 $p->sendMessage("§e<§a幻星碎片§e>§b系统检测到您这是个小号,请使用原来的号公平游戏");
			 return;
			
		}
		
		
		
        if (!$this->pl->exists($n)) {
            $this->pl->set($n, "0");
            $this->pl->set($n . $this->cfg->get("碎片1") , "0");
            $this->pl->set($n . $this->cfg->get("碎片2") , "0");
            $this->pl->set($n . $this->cfg->get("碎片3") , "0");
            $this->pl->set($n . $this->cfg->get("碎片4") , "0");
            $this->pl->set($n . $this->cfg->get("碎片5") , "0");
			 $this->pl->set($n . "合成状态", "未合成");
            $this->pl->save();
            $p->sendMessage("§e<§a幻星碎片§e>§b已帮您生成配置文件 输入/zh 查看帮助");
        } else {
            $p->sendMessage("§e<§a幻星碎片§e>§b输入 /碎片 查看 查看您现有的碎片");
           
        }
		
		
			if($this->date->get("$n") == "$date" and $this->xh->get($n)==0)
			{
								$p->sendMessage("§e<§a幻星碎片§e>§b今天的召唤次数领完啦~~~");
								return true;
							}
							else
							{
						
						$this->date->set("$n",$date);
							
							$this->date->save();
							
						$this->pl->set($n,$this->pl->get($n)+2);
						$this->pl->save();
							$p->sendMessage("§e<§a幻星碎片§e>§b每日登陆赠送您2个召唤次数~~嘿嘿嘿");
							return;
							}
		
    }
	
	
	public function onQ(PlayerQuitEvent $e) 
	{
		$p=$e->getPlayer();
		
		$n=$p->getName();
	
	
	$this->xh->set($n,0);
			 $this->xh->save();
			 
			 //清除小号痕迹
	return;
	
	}
	
	
	public function onPlayerInteract(PlayerInteractEvent $e)
	{
		$p=$e->getPlayer();
		
		$n=$p->getName();
		
		

        $ts=$e->getItem()->getDamage();//特殊值
		
		if($p->getgamemode()==1)
		{
			return;
		}
		
		if($e->getItem()->getId()== 351 and $ts==4)
		{
			$this->pl->set($n,$this->pl->get($n)+1);
						$this->pl->save();
						$p->getInventory()->removeItem(new Item(351,4,1));
							$p->sendMessage("§e<§a幻星碎片§e>§b召唤成功!获得抽奖次数+1~~~");
							return;
		}
		
	}
	
	
    public function onCommand(CommandSender $s, Command $cmd, string $label, array $args):bool
	{
     
	 if($this->cfg->get("全局开关")=="关")
		{
			
		$s->sendMessage("当前未开放碎片收集,请等待腐竹开放！");
			
			return false;
		}
	  
        $n = $s->getName();
        $ny = date("Y");
        $nm = date("m");
        $nd = date("d");
        $mt = mt_rand(1,7);
		$mt2= mt_rand(100,350);
		$mt3=mt_rand(1,20);
        if ($s instanceof Player) {
            if ($cmd == "zh") {
                if (isset($args[0])) {
                    switch ($args[0]) {
                        case "help":
                            $s->sendMessage("§e===§6FancyZH§e===\n§b欢迎您使用FancyZH\n§b这是一款可以收集碎片替换的插件\n§b使用方法很简单,只需要输入特殊指令\n§b请使用指令 /碎片 进行召唤碎片");
                            break;

                        case "info":
                            $s->sendMessage("§e===§6Fragment§e===\n§e作者:§6Magic雪飞\n§e插件版本:§61.0.0\n§e开源地址:§6github.com/MagicBloodFLY\n§b来自 FancyDream Team");
                            return true;
                            break;
                    }
                } else {
                    $s->sendMessage("§e<§a幻星碎片§e>§b请使用正确指令/zh help/info");
                }
            }
            if ($cmd == "碎片") {
                if (empty($args[0])) {
                    $s->sendMessage("§e==================<§a幻星碎片§e>==================§b");
                    $s->sendMessage("§b请使用指令 /碎片 召唤 进行召唤 每天只能召唤两次哦~");
					$s->sendMessage("§b请使用指令 /碎片 查看 查看已有碎片~");
					$s->sendMessage("§b请使用指令 /碎片 赠送 <玩家> <类型> <数量> 进行赠送碎片");
					$s->sendMessage("§b请使用指令 /碎片 合成 进行合成登记 必须在活动开启后才能替换哦~");




				   return false;
					
					
					
					
					
                }
                $e = $args[0];
                switch ($e) {
                    case "召唤":
                        if ($this->pl->get($n) > 0) {
                            if ($mt == 1) {
                                $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您抽到了" . $this->cfg->get("碎片1") . "~,已为您储存！");
                                $this->pl->set($n . $this->cfg->get("碎片1") , $this->pl->get($n . $this->cfg->get("碎片1"))+1);
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
                            }
                            if ($mt == 2) {
                                $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您抽到了" . $this->cfg->get("碎片2") . "~,已为您储存！");
                                $this->pl->set($n . $this->cfg->get("碎片2") , $this->pl->get($n . $this->cfg->get("碎片2"))+1);
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
                            }
                            if ($mt == 3) {
                                $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您抽到了" . $this->cfg->get("碎片3") . "~,已为您储存！");
                                $this->pl->set($n . $this->cfg->get("碎片3") , $this->pl->get($n . $this->cfg->get("碎片3"))+1);
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
                            }
                            if ($mt == 4) {
                                $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您抽到了" . $this->cfg->get("碎片4") . "~,已为您储存！");
                                $this->pl->set($n . $this->cfg->get("碎片4") , $this->pl->get($n . $this->cfg->get("碎片4"))+1);
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
                            }
                            if ($mt3 == 7) {
                                $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您抽到了" . $this->cfg->get("碎片5") . "~,已为您储存！");
                                $this->pl->set($n . $this->cfg->get("碎片5") , $this->pl->get($n . $this->cfg->get("碎片5"))+1);
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
                            }
							if($mt>4)
							{
								$s->sendMessage("§e<§a幻星碎片§e>§bQAQ好遗憾没有抽到呢,但得到了您的专属金币");
								EconomyAPI::getInstance()->addMoney($n,$mt2);
								$s->sendMessage("§e<§a幻星碎片§e>§b您已获得".$mt2."元");
								$this->pl->set($n,$this->pl->get($n)-1);
                                $this->pl->save();
							}
                        } else {
                            $s->sendMessage("§e<§a幻星碎片§e>§b您今天的次数不够了QAQ，现在次数" . $this->pl->get($n));
                       					   }
										   break;
                    case "查看":
                        $s->sendMessage("§e=======<§a幻星碎片§e>=======");
                        $s->sendMessage("§b您现在的拥有的碎片有以下几种");
                        $s->sendMessage("§e" . $this->cfg->get("碎片1") . ":" . $this->pl->get($n . $this->cfg->get("碎片1")) . "个");
                        $s->sendMessage("§e" . $this->cfg->get("碎片2") . ":" . $this->pl->get($n . $this->cfg->get("碎片2")) . "个");
                        $s->sendMessage("§e" . $this->cfg->get("碎片3") . ":" . $this->pl->get($n . $this->cfg->get("碎片3")) . "个");
                        $s->sendMessage("§e" . $this->cfg->get("碎片4") . ":" . $this->pl->get($n . $this->cfg->get("碎片4")) . "个");
                        $s->sendMessage("§e" . $this->cfg->get("碎片5") . ":" . $this->pl->get($n . $this->cfg->get("碎片5")) . "个");
						
						break;
					case "合成":
					
					if($this->cfg->get("替换开关")=="开" and $this->pl->get($n . $this->cfg->get("碎片1"))>3 and $this->pl->get($n . $this->cfg->get("碎片2"))>3 and $this->pl->get($n . $this->cfg->get("碎片3"))>3 and $this->pl->get($n . $this->cfg->get("碎片4"))>3 and $this->pl->get($n . $this->cfg->get("碎片5"))>1)
					{
						 $s->sendMessage("§e<§a幻星碎片§e>§b恭喜您合成成功!奖励".$wp.":".$ts."已发放您的背包 合计".$sl."个");
						$this->pl->set($n . "合成状态", "已合成");
				
				$wp=$this->cfg->get("替换物品");
				
				$ts=$this->cfg->get("替换特殊值");
				
				$sl=$this->cfg->get("替换数量");
				
				
				$s->getInventory()->addItem(new Item($wp,$ts,$sl));

						$this->pl->set($n . $this->cfg->get("碎片1") , $this->pl->get($n . $this->cfg->get("碎片1"))-3);
						$this->pl->set($n . $this->cfg->get("碎片2") , $this->pl->get($n . $this->cfg->get("碎片2"))-3);
						$this->pl->set($n . $this->cfg->get("碎片3") , $this->pl->get($n . $this->cfg->get("碎片3"))-3);
						$this->pl->set($n . $this->cfg->get("碎片4") , $this->pl->get($n . $this->cfg->get("碎片4"))-3);
						$this->pl->set($n . $this->cfg->get("碎片5") , $this->pl->get($n . $this->cfg->get("碎片5"))-2);
						$this->pl->save();
					}
					else
					{
						$s->sendMessage("§e<§a幻星碎片§e>§b开始替换未开始或者您的碎片不够!请耐心集齐碎片或者等待活动开始,使用指令 /碎片 查询 查看现有碎片");
						$s->sendMessage("§e合成需要".$this->cfg->get("碎片1")." ".$this->cfg->get("碎片2")." ".$this->cfg->get("碎片3")." ".$this->cfg->get("碎片4")." 各3个,还有".$this->cfg->get("碎片5")."两个");
					}
					
					break;
					
					
					case "赠送":
						// /碎片 赠送 <玩家> <类型> <数量>
						
						$cfg = $this->cfg->getAll();
						
						if(count($args)<4){
							$this->msg('§e<§a幻星碎片§e>§b赠送方法：/碎片 赠送 <玩家> <类型> <数量>',$s);
							return true;
						}
						$target = $args[1];
						$sp = $args[2];
						$amount = (int) $args[3];
						// 排错
						if(!$this->pl->exists($target)){
							$this->msg('§e<§a幻星碎片§e>§b玩家不存在，请检查拼写(区分大小写)',$s);
							return true;
						}
						if(empty($amount)||$amount<=0){
							$this->msg('§e<§a幻星碎片§e>§b请填写正确的数量',$s);
							return true;
						}
						foreach($cfg as $sptype=>$spname){
							if($spname==$sp){
								$type = $sptype;
								break;
							}
						}
						if(empty($type)){
							$this->msg('§e<§a幻星碎片§e>§b未知的碎片类型，使用"/碎片 查看"命令查看所有碎片类型',$s);
							return true;
						}
					
					$mycount = $this->pl->get($n . $this->cfg->get($type));
						
						$targetcount = $this->pl->get($target . $this->cfg->get($type));
						
						if($mycount<$amount){
							$this->msg('§e<§a幻星碎片§e>§b啊哦，你的'.$sp.'只有'.$mycount.'个了，没法送出'.$amount.'个。',$s);
							return true;
						}
						
						if($target==$n)
						{
					
						$this->msg("§e<§a幻星碎片§e>§b请不要赠送自己碎片哦",$s);
						
						return true;
						}
						
						$mt4=mt_rand(70,200);
						
						$this->pl->set($n . $this->cfg->get($type),$this->pl->get($n . $this->cfg->get($type))-$amount);
						
						$targetcount= $amount+$this->pl->get($target . $this->cfg->get($type));
						
						$this->pl->set($target . $this->cfg->get($type),$targetcount);
						
						$this->pl->save();
						
						$this->msg('§e<§a幻星碎片§e>§b成功向'.$target.'送出'.$amount.'个'.$sp.'。',$s);
						
						$this->getServer()->broadcastMessage("§e<§a幻§e星§d碎§b片§e>§e哇!玩家".$n." 成功向".$target."送出".$amount."个".$sp);
						$this->getServer()->broadcastMessage("§7经过系统鉴定".$n."是个帅帅哒的好人,所以服务器赠送".$mt4."金币给他");
						EconomyAPI::getInstance()->addMoney($n,$mt4);
								$s->sendMessage("§e<§a幻星碎片§e>§b您已获得乐于助人奖励".$mt4."元");
                }
				return true;
            }
        } else {
            $s->sendMessage(TextFormat::GREEN . "请在游戏中使用此命令");
            return true;
        }
    }

	public function msg($msg,Player $p){
		if(!empty($msg)) $p->sendMessage($msg);
	}

	//自定义函数
    public function getStatus(string $name)
    {


        $n = $this->pl->get($name."合成状态");

       return $n;

    }

    public function getFragID()
    {
         $Fragid = $this->cfg->get("替换物品");

         return $Fragid;

    }
    public function getFragName()
    {
        $fragname = $this->cfg->get("替换物品名称");

        return $fragname;
    }
	
	public function getNumber(string $name)
	{
		$number = $this->pl->get($name);
		
		return $number;
		
	}



}

