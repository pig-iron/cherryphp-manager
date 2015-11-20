<?php
// error_reporting(E_ALL^E_NOTICE);
// xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
namespace mcp;
error_reporting(E_ALL);
//error_reporting(null);
require('/www/rogmgr/cherryphp/Cherry.php');
$config="";
\Cherry::Prepare($config);


$statss2=\Init::cache('redis')->_Ckeys("counter:[a-zA-Z]*");


$arr = $statss2;
sort($arr);

if (empty($argv[1])){
    $date = date("Ymd",strtotime("-1 day"));
    $month = date("Ym",strtotime("-1 day"));
}else{
    $date = date("Ymd",strtotime($argv[1]));
    $month = date("Ym",strtotime($argv[1]));
}

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
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_user_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userkey` varchar(100) NOT NULL COMMENT '用户角色项目key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$CreateCharacter_total=empty($all["CreateCharacter"]['total'])?0:$all["CreateCharacter"]['total'];
$UserCount_total=empty($all["UserCount"]['total'])?0:$all["UserCount"]['total'];
$CreateCharacter_today=empty($all["CreateCharacter"]['today'])?0:$all["CreateCharacter"]['today'];
$UserCount_today=empty($all["UserCount"]['today'])?0:$all["UserCount"]['today'];
$sql="INSERT INTO rogmgr_analytics_user_".$month." SET userkey='CreateCharacter', total='".$CreateCharacter_total."', today='".$CreateCharacter_today."', days='".$date."'";
$sql2="INSERT INTO rogmgr_analytics_user_".$month." SET userkey='UserCount', total='".$UserCount_total."', today='".$UserCount_today."', days='".$date."'";
\Init::db()->sql_query($sql);
\Init::db()->sql_query($sql2);
/*用户和角色 存库结束 */

/*剧情 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_plot_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plotkey` varchar(100) NOT NULL COMMENT '剧情key',
  `branch0` int(10) DEFAULT '0' COMMENT '主线剧情',
  `branch1` int(10) DEFAULT '0' COMMENT '支线剧情1',
  `branch2` int(10) DEFAULT '0' COMMENT '支线剧情2',
  `branch0_total` int(10) DEFAULT '0' COMMENT '主线剧情总数',
  `branch1_total` int(10) DEFAULT '0' COMMENT '支线剧情1总数',
  `branch2_total` int(10) DEFAULT '0' COMMENT '支线剧情2总数',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
for($i=1;$i<=15;$i++){
    $sql3="INSERT INTO rogmgr_analytics_plot_".$month." SET plotkey='"."Plot_Race".$i."', ";
    for ($s=0;$s<3;$s++)
    {
        if (!empty($all["Plot_Race".$i."_Branch".$s])){
            $sql3.="branch".$s."='".$all["Plot_Race".$i."_Branch".$s]['today']."', ";
            $sql3.="branch".$s."_total='".$all["Plot_Race".$i."_Branch".$s]['total']."', ";
        }else{
            $sql3.="branch".$s."=0, ";
            $sql3.="branch".$s."_total=0, ";
        }
    }
    $sql3.="days='".$date."';";
    \Init::db()->sql_query($sql3);
}
/*剧情 存库结束 */

/*史诗 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_epic_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `epickey` varchar(100) NOT NULL COMMENT '史诗项目key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
for($i=1;$i<=5;$i++){
    $sql4="INSERT INTO rogmgr_analytics_epic_".$month." SET epickey='"."Epic".$i."', ";
    if (!empty($all["Epic".$i])){
        $sql4.="total='".$all["Epic".$i]['total']."', ";
        $sql4.="today='".$all["Epic".$i]['today']."', ";
    }else{
        $sql4.="total=0, ";
        $sql4.="today=0, ";
    }
    $sql4.="days='".$date."';";
    \Init::db()->sql_query($sql4);
}
/*史诗 存库结束 */

/*战斗统计 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_pvp_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pvpkey` varchar(100) NOT NULL COMMENT '战斗统计项目key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("PVE3Player","PVPNormal","PVPSingleLadder","PVPTeamLadder","PVPGold");
foreach ($arr as $v){
    $sql5="INSERT INTO rogmgr_analytics_pvp_".$month." SET pvpkey='".$v."', ";
    if (!empty($all[$v])){
        $sql5.="total='".$all[$v]['total']."', ";
        $sql5.="today='".$all[$v]['today']."', ";
    }else{
        $sql5.="total=0, ";
        $sql5.="today=0, ";
    }
    $sql5.="days='".$date."';";
    \Init::db()->sql_query($sql5);
}
/*战斗统计 存库结束 */

/*新手教程 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_newbie_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newbiekey` varchar(100) NOT NULL COMMENT '新手项目key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("NewbieBattle1", "NewbieBattle2", "NewbieBattle3", "NewbieStep2", "NewbieStep3", "NewbieStep4", "NewbieStep6", "NewbieStep7");
foreach ($arr as $v){
    $sql6="INSERT INTO rogmgr_analytics_newbie_".$month." SET newbiekey='".$v."', ";
    if (!empty($all[$v])){
        $sql6.="total='".$all[$v]['total']."', ";
        $sql6.="today='".$all[$v]['today']."', ";
    }else{
        $sql6.="total=0, ";
        $sql6.="today=0, ";
    }
    $sql6.="days='".$date."';";
    \Init::db()->sql_query($sql6);
}
/*新手教程 存库结束 */

/*阵容购买及使用 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_lineup_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lineupkey` varchar(100) NOT NULL COMMENT '阵容项目key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("Lineup0UseTimes", "Lineup1UseTimes", "Lineup2UseTimes", "Lineup3UseTimes", "Lineupsize7", "Lineupsize8", "Lineupsize9", "Lineupsize10", "Lineupsize11", "Lineupsize12", "Lineupsize13", "Lineupsize14", "Lineupsize15", "Lineupsize16", "Lineupsize17", "Lineupsize18", "Lineupsize19", "Lineupsize20", "Lineupsize21", "Lineupsize22", "Lineupsize23", "Lineupsize24", "Lineupsize25", "Lineupsize26");
foreach ($arr as $v){
    $sql7="INSERT INTO rogmgr_analytics_lineup_".$month." SET lineupkey='".$v."', ";
    if (!empty($all[$v])){
        $sql7.="total='".$all[$v]['total']."', ";
        $sql7.="today='".$all[$v]['today']."', ";
    }else{
        $sql7.="total=0, ";
        $sql7.="today=0, ";
    }
    $sql7.="days='".$date."';";
    \Init::db()->sql_query($sql7);
}
/*阵容购买及使用 存库结束 */

/*物品道具 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_createitem_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `herokey` varchar(100) NOT NULL COMMENT '英雄key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("CreateItem1000019", "CreateItem1000020", "CreateItem1000021", "CreateItem1000022", "CreateItem1000023", "CreateItem1000024", "CreateItem1000025", "CreateItem1000026", "CreateItem1000027", "CreateItem1000028", "CreateItem1000029", "CreateItem1000030", "CreateItem1000031", "CreateItem1000032", "CreateItem1000033", "CreateItem1000034", "CreateItem1000035", "CreateItem1000036", "CreateItem1000037", "CreateItem1000038", "CreateItem1000039", "CreateItem1000040", "CreateItem1000041", "CreateItem1000042", "CreateItem1000043", "CreateItem1000044", "CreateItem1000045", "CreateItem1000046", "CreateItem1000047", "CreateItem1000048", "CreateItem1000049", "CreateItem1000050", "CreateItem1000051", "CreateItem1000052", "CreateItem1000053", "CreateItem1000054", "CreateItem1000055");
foreach ($arr as $v){
    $sql8="INSERT INTO rogmgr_analytics_createitem_".$month." SET herokey='".$v."', ";
    if (!empty($all[$v])){
        $sql8.="total='".$all[$v]['total']."', ";
        $sql8.="today='".$all[$v]['today']."', ";
    }else{
        $sql8.="total=0, ";
        $sql8.="today=0, ";
    }
    $sql8.="days='".$date."';";
    \Init::db()->sql_query($sql8);
}
/*物品道具 存库结束 */


/*英雄使用 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_herousetime_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `herokey` varchar(100) NOT NULL COMMENT '英雄key',
  `total` int(10) DEFAULT '0' COMMENT '总数',
  `today` int(10) DEFAULT '0' COMMENT '当天数量',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("Hero5UseTimesByPlayerInPVP", "Hero10UseTimesByPlayerInPVP", "Hero15UseTimesByPlayerInPVP", "Hero20UseTimesByPlayerInPVP", "Hero25UseTimesByPlayerInPVP", "Hero30UseTimesByPlayerInPVP", "Hero35UseTimesByPlayerInPVP", "Hero40UseTimesByPlayerInPVP", "Hero45UseTimesByPlayerInPVP", "Hero50UseTimesByPlayerInPVP", "Hero55UseTimesByPlayerInPVP", "Hero60UseTimesByPlayerInPVP", "Hero65UseTimesByPlayerInPVP", "Hero70UseTimesByPlayerInPVP", "Hero75UseTimesByPlayerInPVP", "Hero80UseTimesByPlayerInPVP", "Hero85UseTimesByPlayerInPVP", "Hero90UseTimesByPlayerInPVP", "Hero113UseTimesByPlayerInPVP", "Hero118UseTimesByPlayerInPVP", "Hero123UseTimesByPlayerInPVP", "Hero128UseTimesByPlayerInPVP", "Hero133UseTimesByPlayerInPVP", "Hero138UseTimesByPlayerInPVP", "Hero143UseTimesByPlayerInPVP", "Hero176UseTimesByPlayerInPVP", "Hero181UseTimesByPlayerInPVP");
foreach ($arr as $v){
    $sql9="INSERT INTO rogmgr_analytics_herousetime_".$month." SET herokey='".$v."', ";
    if (!empty($all[$v])){
        $sql9.="total='".$all[$v]['total']."', ";
        $sql9.="today='".$all[$v]['today']."', ";
    }else{
        $sql9.="total=0, ";
        $sql9.="today=0, ";
    }
    $sql9.="days='".$date."';";
    \Init::db()->sql_query($sql9);
}
/*英雄使用 存库结束 */

/*英雄强化 存库开始 */
$t_sql="CREATE TABLE IF NOT EXISTS `rogmgr_analytics_herostrlv_".$month."` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `herokey` varchar(100) NOT NULL COMMENT '英雄key',
  `strengthLv1` int(10) DEFAULT '0' COMMENT '1级强化',
  `strengthLv2` int(10) DEFAULT '0' COMMENT '2级强化',
  `strengthLv3` int(10) DEFAULT '0' COMMENT '3级强化',
  `strengthLv1_total` int(10) DEFAULT '0' COMMENT '1级强化总数',
  `strengthLv2_total` int(10) DEFAULT '0' COMMENT '2级强化总数',
  `strengthLv3_total` int(10) DEFAULT '0' COMMENT '3级强化总数',
  `days` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
\Init::db()->sql_query($t_sql);
$arr=array("hero5_strengthLv", "hero10_strengthLv", "hero15_strengthLv", "hero20_strengthLv", "hero25_strengthLv", "hero30_strengthLv", "hero35_strengthLv", "hero40_strengthLv", "hero45_strengthLv", "hero50_strengthLv", "hero55_strengthLv", "hero60_strengthLv", "hero65_strengthLv", "hero70_strengthLv", "hero75_strengthLv", "hero80_strengthLv", "hero85_strengthLv", "hero90_strengthLv", "hero113_strengthLv", "hero118_strengthLv", "hero123_strengthLv", "hero128_strengthLv", "hero133_strengthLv", "hero138_strengthLv", "hero143_strengthLv", "hero176_strengthLv", "hero181_strengthLv");
foreach ($arr as $v){
    $sql10="INSERT INTO rogmgr_analytics_herostrlv_".$month." SET herokey='".$v."', ";
    for ($i=1;$i<=3;$i++)
    {
        if (!empty($all[$v.$i])){
        $sql10.="strengthLv".$i."_total='".$all[$v.$i]['total']."', ";
        $sql10.="strengthLv".$i."='".$all[$v.$i]['today']."', ";
        }else{
            $sql10.="strengthLv".$i."_total=0, ";
            $sql10.="strengthLv".$i."=0, ";
        }
    }
    $sql10.="days='".$date."';";
    \Init::db()->sql_query($sql10);
}
/*英雄强化 存库结束 */