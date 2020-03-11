![Fancy](http://www.funmc.cc/frag.png)

<h1>FragMent是什么?</h1>
一款运行在PocketMine服务器上的插件
可增加游戏乐趣且可以保留服主控制权的碎片插件 

> 简洁快捷
* 方便的`碎片管理`功能
    *  服主可以在配置文件管理玩家的碎片数量
    *  主文件可以调控碎片合成开关
* 简单高效的`防小号`功能
  *  玩家CID自动分辨,防小号互刷碎片
* 配置高度自由`随意修改`服主完全自定义插件玩法
 *  可控制的合成碎片名字
 *  可控制的合成物品数量

**插件使用简介**

|使用简介|指令|
|--|--|
| 每日获取碎片 | /碎片 召唤 |
| 查询自己的碎片 | /碎片 查看 |
| 赠送碎片 | /碎片 赠送 <玩家> <类型> <数量>|
| 碎片合成 | /碎片 合成 |

</br>

> 全新版本1.0.2

**现已全面支持PocketMine`3.0`API**

如果您是开发者,那么您将可以使用碎片插件全新的API来获取你想要的的内容

* Firstly
    * 你必须在插件里面 `use\FragMent\FragMent;` 和 `$this->frag=FragMent::getInstance();`

* Sencondly
    * 你可以使用以下代码来获取内容
    * 获取玩家合成状态`$this->frag->getStatus($name);`
    * 获取插件合成物品的ID`$this->frag->getFragID();`
    * 获取插件合成物品的名称`$this->frag->getFragName();`
    * 获取玩家当前可抽取的次数`$this->frag->getNumber($name);`
    
* Finally
   * 把你写好的的插件与FragMent一起安装,享受搜集插件的乐趣

</br>

> 下一次更新方向

* 编写更多的API支持

* 与`Fancy团队`的另一款插件实现底部显示或者计分板显示

* 优化使用简洁度

* 或者还会有`Gui`界面......

</br>

**有问题反馈**
 
> "欢迎提出意见"

在使用中有任何问题，欢迎反馈给我，可以用以下联系方式跟我交流

* 邮件(2290657746@qq.com)
* QQ: 2290657746

**更多好玩实用插件**

关于<b>FancyDream</b>其它作品

* [PointCard 点卡](https://github.com/Cansll/PointCard) 
* [CkLottery 彩票](https://github.com/Cansll/CkLottery)
* [ItemFrameNoDrop 防物品栏掉落](https://github.com/FancyDreamTeam/ItemFrameNoDrop)
* [CkVIPs 会员](https://github.com/Cansll/CkVIPs)
* [FancyTips 底部显示](https://github.com/MagicBloodFly/FancyTips)

**关于作者**

```javascript
  var Fancy = {
    Name  : "Magic雪飞",
    GitHub : "http://github.com/MagicBloodFLY"
  }
```


