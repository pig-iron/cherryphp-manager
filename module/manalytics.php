<?php
namespace module;
class manalytics
{
	public static $aws;
	public function __construct()
	{
       
	}
    
    public static function get_now()
    {
            $statss2=\Init::cache('redis')->_Ckeys("counter:[a-zA-Z]*");
            $arr = $statss2;
            sort($arr);
            $date = date("Ymd",time());
            $month = date("Ym",time());
            $all = array();
            foreach($arr as $key)
            {
                $infoarr = explode(":", $key);
                if(count($infoarr) != 2)
                    continue;
                $history_total=\Init::cache('redis')->_Ckeys("counter:*".$infoarr[1]);
                
                sort($history_total);
                $totalVal = 0;
                foreach ($history_total as $v){
                    $keyArr = explode(":", $v);
                    $keys = substr($keyArr[1], 0, 8);
                    if ($keys==$date){
                       break;
                    }
                    $val=\Init::cache('redis')->_Cget("counter:".$keys.$infoarr[1]);
                    $totalVal += intval($val);
                }
                
                
                // $total = \Init::cache('redis')->_Cget($key);
                // $total = empty($total)?0:$total;
                $totalVal = empty($totalVal)?0:$totalVal;
                
                $str = "counter:".$date.$infoarr[1];
                $today = \Init::cache('redis')->_Cget($str);
                $today = empty($today)?0:$today;

                
                $all[$infoarr[1]]["total"]=$totalVal;
                $all[$infoarr[1]]["today"]=$today;
            };
            
            // print_r($all);exit;
            /*用户和角色 存库开始 */
            
            $CreateCharacter_total=empty($all["CreateCharacter"]['total'])?0:$all["CreateCharacter"]['total'];
            $UserCount_total=empty($all["UserCount"]['total'])?0:$all["UserCount"]['total'];
            $CreateCharacter_today=empty($all["CreateCharacter"]['today'])?0:$all["CreateCharacter"]['today'];
            $UserCount_today=empty($all["UserCount"]['today'])?0:$all["UserCount"]['today'];
           
            $allres=array();
            $allres['user']=array();
            $allres['user']['CreateCharacter']['total']=$CreateCharacter_total;
            $allres['user']['CreateCharacter']['today']=$CreateCharacter_today;
            $allres['user']['UserCount']['total']=$UserCount_total;
            $allres['user']['UserCount']['today']=$UserCount_today;
            
            
            /*用户和角色 存库结束 */

            /*剧情 存库开始 */
            
            for($i=1;$i<=15;$i++){
                $allres['plot']["Plot_Race".$i]=array();
                for ($s=0;$s<3;$s++)
                {
                    if (!empty($all["Plot_Race".$i."_Branch".$s])){
                        $allres['plot']["Plot_Race".$i]["branch".$s]=$all["Plot_Race".$i."_Branch".$s]['today'];
                        $allres['plot']["Plot_Race".$i]["branch".$s."_total"]=$all["Plot_Race".$i."_Branch".$s]['total'];
                    }else{
                        $allres['plot']["Plot_Race".$i]["branch".$s]=0;
                        $allres['plot']["Plot_Race".$i]["branch".$s."_total"]=0;
                    }
                }
            }
            
            /*剧情 存库结束 */

            /*史诗 存库开始 */
            for($i=1;$i<=5;$i++){
               $allres['epic']["Epic".$i]=array();
                if (!empty($all["Epic".$i])){
                    $allres['epic']["Epic".$i]["total"]=$all["Epic".$i]['total'];
                    $allres['epic']["Epic".$i]["today"]=$all["Epic".$i]['today'];
                }else{
                    $allres['epic']["Epic".$i]["total"]=0;
                    $allres['epic']["Epic".$i]["today"]=0;
                }
            }
            
            /*史诗 存库结束 */

            /*战斗统计 存库开始 */
            
            $arr=array("PVE3Player","PVPNormal","PVPSingleLadder","PVPTeamLadder","PVPGold");
            foreach ($arr as $v){
                $allres['pvp'][$v]=array();
                if (!empty($all[$v])){
                    $allres['pvp'][$v]["total"]=$all[$v]['total'];
                    $allres['pvp'][$v]["today"]=$all[$v]['today'];
                }else{
                    $allres['pvp'][$v]["total"]=0;
                    $allres['pvp'][$v]["today"]=0;
                }
            }
            /*战斗统计 存库结束 */

            /*新手教程 存库开始 */
           
            $arr=array("NewbieBattle1", "NewbieBattle2", "NewbieBattle3", "NewbieStep2", "NewbieStep3", "NewbieStep4", "NewbieStep6", "NewbieStep7");
            foreach ($arr as $v){
                $allres["newbie"][$v]=array();
                if (!empty($all[$v])){
                    $allres["newbie"][$v]["total"]=$all[$v]['total'];
                    $allres["newbie"][$v]["today"]=$all[$v]['today'];
                }else{
                    $allres["newbie"][$v]["total"]=0;
                    $allres["newbie"][$v]["today"]=0;
                }
            }
            /*新手教程 存库结束 */

            /*阵容购买及使用 存库开始 */
            
            $arr=array("Lineup0UseTimes", "Lineup1UseTimes", "Lineup2UseTimes", "Lineup3UseTimes", "Lineupsize7", "Lineupsize8", "Lineupsize9", "Lineupsize10", "Lineupsize11", "Lineupsize12", "Lineupsize13", "Lineupsize14", "Lineupsize15", "Lineupsize16", "Lineupsize17", "Lineupsize18", "Lineupsize19", "Lineupsize20", "Lineupsize21", "Lineupsize22", "Lineupsize23", "Lineupsize24", "Lineupsize25", "Lineupsize26");
            foreach ($arr as $v){
                $allres["lineup"][$v]=array();
                if (!empty($all[$v])){
                    $allres["lineup"][$v]["total"]=$all[$v]['total'];
                    $allres["lineup"][$v]["today"]=$all[$v]['today'];
                }else{
                    $allres["lineup"][$v]["total"]=0;
                    $allres["lineup"][$v]["today"]=0;
                }
            }
            /*阵容购买及使用 存库结束 */

            /*物品道具 存库开始 */
            
            $arr=array("CreateItem1000019", "CreateItem1000020", "CreateItem1000021", "CreateItem1000022", "CreateItem1000023", "CreateItem1000024", "CreateItem1000025", "CreateItem1000026", "CreateItem1000027", "CreateItem1000028", "CreateItem1000029", "CreateItem1000030", "CreateItem1000031", "CreateItem1000032", "CreateItem1000033", "CreateItem1000034", "CreateItem1000035", "CreateItem1000036", "CreateItem1000037", "CreateItem1000038", "CreateItem1000039", "CreateItem1000040", "CreateItem1000041", "CreateItem1000042", "CreateItem1000043", "CreateItem1000044", "CreateItem1000045", "CreateItem1000046", "CreateItem1000047", "CreateItem1000048", "CreateItem1000049", "CreateItem1000050", "CreateItem1000051", "CreateItem1000052", "CreateItem1000053", "CreateItem1000054", "CreateItem1000055");
            foreach ($arr as $v){
                $allres["createitem"][$v]=array();
                if (!empty($all[$v])){
                    $allres["createitem"][$v]["total"]=$all[$v]['total'];
                    $allres["createitem"][$v]["today"]=$all[$v]['today'];
                }else{
                    $allres["createitem"][$v]["total"]=0;
                    $allres["createitem"][$v]["today"]=0;
                }
            }
            /*物品道具 存库结束 */


            /*英雄使用 存库开始 */
            
            $arr=array("Hero5UseTimesByPlayerInPVP", "Hero10UseTimesByPlayerInPVP", "Hero15UseTimesByPlayerInPVP", "Hero20UseTimesByPlayerInPVP", "Hero25UseTimesByPlayerInPVP", "Hero30UseTimesByPlayerInPVP", "Hero35UseTimesByPlayerInPVP", "Hero40UseTimesByPlayerInPVP", "Hero45UseTimesByPlayerInPVP", "Hero50UseTimesByPlayerInPVP", "Hero55UseTimesByPlayerInPVP", "Hero60UseTimesByPlayerInPVP", "Hero65UseTimesByPlayerInPVP", "Hero70UseTimesByPlayerInPVP", "Hero75UseTimesByPlayerInPVP", "Hero80UseTimesByPlayerInPVP", "Hero85UseTimesByPlayerInPVP", "Hero90UseTimesByPlayerInPVP", "Hero113UseTimesByPlayerInPVP", "Hero118UseTimesByPlayerInPVP", "Hero123UseTimesByPlayerInPVP", "Hero128UseTimesByPlayerInPVP", "Hero133UseTimesByPlayerInPVP", "Hero138UseTimesByPlayerInPVP", "Hero143UseTimesByPlayerInPVP", "Hero176UseTimesByPlayerInPVP", "Hero181UseTimesByPlayerInPVP");
            foreach ($arr as $v){
                $allres["herousetime"][$v]=array();
                if (!empty($all[$v])){
                    $allres["herousetime"][$v]["total"]=$all[$v]['total'];
                    $allres["herousetime"][$v]["today"]=$all[$v]['today'];
                }else{
                    $allres["herousetime"][$v]["total"]=0;
                    $allres["herousetime"][$v]["today"]=0;
                }
            }
            /*英雄使用 存库结束 */

            /*英雄强化 存库开始 */
           
            $arr=array("hero5_strengthLv", "hero10_strengthLv", "hero15_strengthLv", "hero20_strengthLv", "hero25_strengthLv", "hero30_strengthLv", "hero35_strengthLv", "hero40_strengthLv", "hero45_strengthLv", "hero50_strengthLv", "hero55_strengthLv", "hero60_strengthLv", "hero65_strengthLv", "hero70_strengthLv", "hero75_strengthLv", "hero80_strengthLv", "hero85_strengthLv", "hero90_strengthLv", "hero113_strengthLv", "hero118_strengthLv", "hero123_strengthLv", "hero128_strengthLv", "hero133_strengthLv", "hero138_strengthLv", "hero143_strengthLv", "hero176_strengthLv", "hero181_strengthLv");
            foreach ($arr as $v){
                $allres["herostrlv"][$v]=array();
                for ($i=1;$i<=3;$i++)
                {
                    if (!empty($all[$v.$i])){
                        $allres["herostrlv"][$v]["strengthLv".$i."_total"]=$all[$v.$i]['total'];
                        $allres["herostrlv"][$v]["strengthLv".$i]=$all[$v.$i]['today'];
                    }else{
                        $allres["herostrlv"][$v]["strengthLv".$i."_total"]=0;
                        $allres["herostrlv"][$v]["strengthLv".$i]=0;
                    }
                }
            }
            /*英雄强化 存库结束 */
            return $allres;
    }
    
    public static function get_day($params)
    {
        $date=date("Ym",time());
        $sql1="SELECT * FROM rogmgr_analytics_user_".$date." WHERE days='".$params['date']."'";
		$res=\Init::db()->fetch_query($sql1);
        $sql2="SELECT * FROM rogmgr_analytics_createitem_".$date." WHERE days='".$params['date']."'";
		$res2=\Init::db()->fetch_query($sql2);
        $sql3="SELECT * FROM rogmgr_analytics_herousetime_".$date." WHERE days='".$params['date']."'";
		$res3=\Init::db()->fetch_query($sql3);
        $sql4="SELECT * FROM rogmgr_analytics_herostrlv_".$date." WHERE days='".$params['date']."'";
		$res4=\Init::db()->fetch_query($sql4);
        $sql5="SELECT * FROM rogmgr_analytics_plot_".$date." WHERE days='".$params['date']."'";
		$res5=\Init::db()->fetch_query($sql5);
        $sql6="SELECT * FROM rogmgr_analytics_pvp_".$date." WHERE days='".$params['date']."'";
		$res6=\Init::db()->fetch_query($sql6);
        $sql7="SELECT * FROM rogmgr_analytics_newbie_".$date." WHERE days='".$params['date']."'";
		$res7=\Init::db()->fetch_query($sql7);
        $sql8="SELECT * FROM rogmgr_analytics_lineup_".$date." WHERE days='".$params['date']."'";
		$res8=\Init::db()->fetch_query($sql8);
        $sql9="SELECT * FROM rogmgr_analytics_epic_".$date." WHERE days='".$params['date']."'";
		$res9=\Init::db()->fetch_query($sql9);
        $all=array();
        $all['user']=array();
        foreach ($res as $v){
            if ($v['userkey']=='CreateCharacter'){
                $all['user']['CreateCharacter']['total']=$v['total'];
                $all['user']['CreateCharacter']['today']=$v['today'];
            }
            if ($v['userkey']=='UserCount'){
                $all['user']['UserCount']['total']=$v['total'];
                $all['user']['UserCount']['today']=$v['today'];
            } 
        }
        foreach ($res2 as $v){
            $all['createitem'][$v['herokey']]['total']=$v['total'];
            $all['createitem'][$v['herokey']]['today']=$v['today'];
        }
        foreach ($res3 as $v){
            $all['herousetime'][$v['herokey']]['total']=$v['total'];
            $all['herousetime'][$v['herokey']]['today']=$v['today'];
        }
        foreach ($res4 as $v){
            $all['herostrlv'][$v['herokey']]['strengthLv1']=$v['strengthLv1'];
            $all['herostrlv'][$v['herokey']]['strengthLv2']=$v['strengthLv2'];
            $all['herostrlv'][$v['herokey']]['strengthLv3']=$v['strengthLv3'];
            $all['herostrlv'][$v['herokey']]['strengthLv1_total']=$v['strengthLv1_total'];
            $all['herostrlv'][$v['herokey']]['strengthLv2_total']=$v['strengthLv2_total'];
            $all['herostrlv'][$v['herokey']]['strengthLv3_total']=$v['strengthLv3_total'];
        }
        foreach ($res5 as $v){
            $all['plot'][$v['plotkey']]['branch0']=$v['branch0'];
            $all['plot'][$v['plotkey']]['branch1']=$v['branch1'];
            $all['plot'][$v['plotkey']]['branch2']=$v['branch2'];
            $all['plot'][$v['plotkey']]['branch0_total']=$v['branch0_total'];
            $all['plot'][$v['plotkey']]['branch1_total']=$v['branch1_total'];
            $all['plot'][$v['plotkey']]['branch2_total']=$v['branch2_total'];
        }
        foreach ($res6 as $v){
            $all['pvp'][$v['pvpkey']]['total']=$v['total'];
            $all['pvp'][$v['pvpkey']]['today']=$v['today'];
        }
        foreach ($res7 as $v){
            $all['newbie'][$v['newbiekey']]['total']=$v['total'];
            $all['newbie'][$v['newbiekey']]['today']=$v['today'];
        }
        foreach ($res8 as $v){
            $all['lineup'][$v['lineupkey']]['total']=$v['total'];
            $all['lineup'][$v['lineupkey']]['today']=$v['today'];
        }
        foreach ($res9 as $v){
            $all['epic'][$v['epickey']]['total']=$v['total'];
            $all['epic'][$v['epickey']]['today']=$v['today'];
        }
        
		return $all;
    }
    
    public static function get_details($params)
    {
        $createitem=array("CreateItem1000019"=>"圣骑士", "CreateItem1000020"=>"圣枪", "CreateItem1000021"=>"大法师", "CreateItem1000022"=>"剑圣", "CreateItem1000023"=>"先知", "CreateItem1000024"=>"巫医", "CreateItem1000025"=>"游侠", "CreateItem1000026"=>"德鲁伊", "CreateItem1000027"=>"丛林刺客", "CreateItem1000028"=>"死亡骑士", "CreateItem1000029"=>"巫妖", "CreateItem1000030"=>"僵尸王", "CreateItem1000031"=>"狂战士", "CreateItem1000032"=>"炼金术士", "CreateItem1000033"=>"酒鬼", "CreateItem1000034"=>"冒险家", "CreateItem1000035"=>"魔偶师", "CreateItem1000036"=>"吟游诗人", "CreateItem1000037"=>"经验双倍卡", "CreateItem1000038"=>"熟练双倍卡", "CreateItem1000039"=>"金币双倍卡", "CreateItem1000040"=>"30天VIP卡", "CreateItem1000041"=>"360天VIP卡", "CreateItem1000042"=>"英雄双倍经验卡一场", "CreateItem1000043"=>"英雄双倍经验卡五场", "CreateItem1000044"=>"英雄双倍经验卡十场", "CreateItem1000045"=>"金币包", "CreateItem1000046"=>"火焰领主", "CreateItem1000047"=>"寒冰领主", "CreateItem1000048"=>"雷霆领主", "CreateItem1000049"=>"血腥女王", "CreateItem1000050"=>"商业大亨", "CreateItem1000051"=>"工程大师", "CreateItem1000052"=>"恶灵大帝", "CreateItem1000053"=>"赌神", "CreateItem1000054"=>"锻造大师", "CreateItem1000055"=>"周免随机");
        $pvp=array("PVE3Player"=>"3玩家对战3AI战斗场数", "PVPNormal"=>"普通pvp战斗场数", "PVPSingleLadder"=>"单人天梯战斗场数", "PVPTeamLadder"=>"组队天梯战斗场数", "PVPGold"=>"金币场战斗场数");
        $herousetime=array("Hero5UseTimesByPlayerInPVP"=>"圣骑士", "Hero10UseTimesByPlayerInPVP"=>"圣枪", "Hero15UseTimesByPlayerInPVP"=>"大法师", "Hero20UseTimesByPlayerInPVP"=>"剑圣", "Hero25UseTimesByPlayerInPVP"=>"先知", "Hero30UseTimesByPlayerInPVP"=>"巫医", "Hero35UseTimesByPlayerInPVP"=>"游侠", "Hero40UseTimesByPlayerInPVP"=>"德鲁伊", "Hero45UseTimesByPlayerInPVP"=>"丛林刺客", "Hero50UseTimesByPlayerInPVP"=>"死亡骑士", "Hero55UseTimesByPlayerInPVP"=>"巫妖", "Hero60UseTimesByPlayerInPVP"=>"僵尸王", "Hero65UseTimesByPlayerInPVP"=>"狂战士", "Hero70UseTimesByPlayerInPVP"=>"炼金术士", "Hero75UseTimesByPlayerInPVP"=>"酒鬼", "Hero80UseTimesByPlayerInPVP"=>"冒险家", "Hero85UseTimesByPlayerInPVP"=>"魔偶师", "Hero90UseTimesByPlayerInPVP"=>"吟游诗人", "Hero113UseTimesByPlayerInPVP"=>"商业大亨", "Hero118UseTimesByPlayerInPVP"=>"工程大师", "Hero123UseTimesByPlayerInPVP"=>"火焰领主", "Hero128UseTimesByPlayerInPVP"=>"寒冰领主", "Hero133UseTimesByPlayerInPVP"=>"雷霆领主", "Hero138UseTimesByPlayerInPVP"=>"恶灵大帝", "Hero143UseTimesByPlayerInPVP"=>"血腥女王", "Hero176UseTimesByPlayerInPVP"=>"赌神", "Hero181UseTimesByPlayerInPVP"=>"锻造大师");
        $herostrlv=array("hero5_strengthLv"=>"圣骑士", "hero10_strengthLv"=>"圣枪", "hero15_strengthLv"=>"大法师", "hero20_strengthLv"=>"剑圣", "hero25_strengthLv"=>"先知", "hero30_strengthLv"=>"巫医", "hero35_strengthLv"=>"游侠", "hero40_strengthLv"=>"德鲁伊", "hero45_strengthLv"=>"丛林刺客", "hero50_strengthLv"=>"死亡骑士", "hero55_strengthLv"=>"巫妖", "hero60_strengthLv"=>"僵尸王", "hero65_strengthLv"=>"狂战士", "hero70_strengthLv"=>"炼金术士", "hero75_strengthLv"=>"酒鬼", "hero80_strengthLv"=>"冒险家", "hero85_strengthLv"=>"魔偶师", "hero90_strengthLv"=>"吟游诗人", "hero113_strengthLv"=>"商业大亨", "hero118_strengthLv"=>"工程大师", "hero123_strengthLv"=>"火焰领主", "hero128_strengthLv"=>"寒冰领主", "hero133_strengthLv"=>"雷霆领主", "hero138_strengthLv"=>"恶灵大帝", "hero143_strengthLv"=>"血腥女王", "hero176_strengthLv"=>"赌神", "hero181_strengthLv"=>"锻造大师");
        $plot=array("Plot_Race1"=>"人族", "Plot_Race2"=>"兽人", "Plot_Race3"=>"精灵", "Plot_Race4"=>"亡灵", "Plot_Race5"=>"矮人", "Plot_Race6"=>"侏儒", "Plot_Race7"=>"元素", "Plot_Race8"=>"地精", "Plot_Race9"=>"血羽", "Plot_Race10"=>"恶魔", "Plot_Race11"=>"鱼人", "Plot_Race12"=>"虚灵", "Plot_Race13"=>"熊猫", "Plot_Race14"=>"沙灵", "Plot_Race15"=>"机械");
        $newbie=array("NewbieBattle1"=>"新手第一战通过人数", "NewbieBattle2"=>"新手第二战通过人数", "NewbieBattle3"=>"新手第三战通过人数", "NewbieStep2"=>"新手战斗胜利过度界面人数", "NewbieStep3"=>"新手阵容指引人数", "NewbieStep4"=>"新手练习赛指引人数", "NewbieStep6"=>"新手神术学习指引人数", "NewbieStep7"=>"通过新手的人数");
        $lineup=array("Lineup0UseTimes"=>"第一套阵容使用次数", "Lineup1UseTimes"=>"第二套阵容使用次数", "Lineup2UseTimes"=>"第三套阵容使用次数", "Lineup3UseTimes"=>"第四套阵容使用次数", "Lineupsize7"=>"购买第7阵容格", "Lineupsize8"=>"购买第8阵容格", "Lineupsize9"=>"购买第9阵容格", "Lineupsize10"=>"购买第10阵容格", "Lineupsize11"=>"购买第11阵容格", "Lineupsize12"=>"购买第12阵容格", "Lineupsize13"=>"购买第13阵容格", "Lineupsize14"=>"购买第14阵容格", "Lineupsize15"=>"购买第15阵容格", "Lineupsize16"=>"购买第16阵容格", "Lineupsize17"=>"购买第17阵容格", "Lineupsize18"=>"购买第18阵容格", "Lineupsize19"=>"购买第19阵容格", "Lineupsize20"=>"购买第20阵容格", "Lineupsize21"=>"购买第21阵容格", "Lineupsize22"=>"购买第22阵容格", "Lineupsize23"=>"购买第23阵容格", "Lineupsize24"=>"购买第24阵容格", "Lineupsize25"=>"购买第25阵容格", "Lineupsize26"=>"购买第26阵容格");
        $epic=array("Epic1"=>"史诗1通关人数", "Epic2"=>"史诗2通关人数", "Epic3"=>"史诗3通关人数", "Epic4"=>"史诗4通关人数", "Epic5"=>"史诗5通关人数");
        $user=array('CreateCharacter'=>"创建角色数量", 'UserCount'=>"访问用户数量");
        $plot_s=array('branch0'=>"主线剧情",'branch1'=>"支线剧情1",'branch2'=>"支线剧情2",'branch0_total'=>"主线剧情",'branch1_total'=>"支线剧情1",'branch2_total'=>"支线剧情2");
        $herostrlv_s=array('strengthLv1'=>"1级强化",'strengthLv2'=>"2级强化",'strengthLv3'=>"3级强化",'strengthLv1_total'=>"1级强化",'strengthLv2_total'=>"2级强化",'strengthLv3_total'=>"3级强化");
        
        $arr_key=array("createitem"=>"herokey","epic"=>"epickey","herostrlv"=>"herokey","herousetime"=>"herokey","lineup"=>"lineupkey","newbie"=>"newbiekey","plot"=>"plotkey","pvp"=>"pvpkey","user"=>"userkey");
        $arr_nkey=array("createitem"=>"物品道具","epic"=>"史诗","herostrlv"=>"英雄强化","herousetime"=>"英雄使用","lineup"=>"阵容购买及使用","newbie"=>"新手教程","plot"=>"剧情通关","pvp"=>"战斗统计","user"=>"用户角色");
        $endmonth=date("Ym",strtotime("-1 day"));
        $endday=date("Y-m-d",strtotime("-1 day"));
        $startday=date("Y-m-d",strtotime("-30 day"));
        $startmonth=date("Ym",strtotime("-30 day"));
        for ($i=30;$i>=1;$i--){
            $date_arr[]=date("Y-m-d",strtotime("-".$i." day"));
        }
        // echo "<pre>";
        // print_r($startday);
        // print_r($date_arr);exit;
        if (!empty($params['s'])){
            $name=$arr_nkey[$params['k']]."-".${$params['k']}[$params['v']].${$params['k']."_s"}[$params['s']];
        }else{
            $name=$arr_nkey[$params['k']]."-".${$params['k']}[$params['v']];
        }
        $key=$arr_key[$params['k']];
        
        if ($startmonth==$endmonth){
            if (!empty($params['s'])){
                $sql1="SELECT ".$params['s']." AS today, ".$params['s']."_total AS total, days FROM rogmgr_analytics_".$params["k"]."_".$startmonth." WHERE ".$key."='".$params['v']."' days BETWEEN '".$startday."' AND '".$endday."'";
            }else{
                $sql1="SELECT * FROM rogmgr_analytics_".$params["k"]."_".$startmonth." WHERE ".$key."='".$params['v']."' days BETWEEN '".$startday."' AND '".$endday."'";
            }
        }else{
            if (!empty($params['s'])){
                $sql1="(SELECT ".$params['s']." AS today, ".$params['s']."_total AS total, days FROM rogmgr_analytics_".$params["k"]."_".$startmonth." WHERE ".$key."='".$params['v']."' AND days BETWEEN '".$startday."' AND '".$endday."') UNION (SELECT ".$params['s']." AS today, ".$params['s']."_total AS total, days FROM rogmgr_analytics_".$params["k"]."_".$endmonth." WHERE ".$key."='".$params['v']."' AND days BETWEEN '".$startday."' AND '".$endday."')";
            }else{
                $sql1="(SELECT * FROM rogmgr_analytics_".$params["k"]."_".$startmonth." WHERE ".$key."='".$params['v']."' AND days BETWEEN '".$startday."' AND '".$endday."') UNION (SELECT * FROM rogmgr_analytics_".$params["k"]."_".$endmonth." WHERE ".$key."='".$params['v']."' AND days BETWEEN '".$startday."' AND '".$endday."')";
            }
        }
        // print_r($sql1);exit;
		$res=\Init::db()->fetch_query($sql1);
        $all=array();
        foreach ($res as $v)
        {
            $all[$v['days']]["total"]=$v['total'];
            $all[$v['days']]["today"]=$v['today'];
        }
        $alldata=array();
        foreach($date_arr as $v){
            if (!empty($all[$v]['total'])){
                $alldata[$v]['total']=$all[$v]['total'];
            }else{
                $alldata[$v]['total']=0;
            }
            if (!empty($all[$v]['today'])){
                $alldata[$v]['today']=$all[$v]['today'];
            }else{
                $alldata[$v]['today']=0;
            }
        }
        // echo "<pre>";
        // print_r($alldata);exit;
        $allres=array();
        $allres['date']=$date_arr;
        $allres['data']=$alldata;
        $allres['name']=$name;
        return $allres;
    }
}