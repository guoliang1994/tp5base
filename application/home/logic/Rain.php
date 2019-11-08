<?php
namespace app\home\logic;

use think\Model;
use think\Db;

/*
 * 站点降雨量
 * */
class Rain extends Model
{
    public function fall(&$siteInfo, $start, $over)
    {
        if(!empty($siteInfo)) {
            $sql = "select ifnull(sum(drp), 0) as sum, tm from lab_st_pptn_r 
                            where stcd='{$siteInfo['stcd']}' 
                            and tm > '{$start}'and tm <= '{$over}' 
                            order by tm desc";
            $rainfall = $this->query($sql);
            $siteInfo['sum_drp'] = $rainfall[0]['sum'];
        } else {
            $siteInfo['sum_drp'] = 0;
        }
    }
    public function historyRecord($stcd, $startTime, $endTime)
    {
        $db = Db::table('lab_st_pptn_r');
        $data = $db->field('tm,drp')
            ->where(['stcd' => $stcd])
            ->whereBetween('tm', [$startTime, $endTime])
            ->order('tm', 'asc')
            ->select();
        return $data;
    }
    public function rainfallBetween($stcd, $startTime, $endTime)
    {
        $db = Db::name('st_pptn_r');
        $max = $db->where(['stcd' => $stcd])->whereBetween('tm', [$startTime, $endTime])->max('drp');
        $min = $db->where(['stcd' => $stcd])->whereBetween('tm', [$startTime, $endTime])->min('drp');
        return ['max' => $max, 'min' => $min];
    }
    /*
     * 根据时间查询统计
     * */
    public function statistics($stcd, $startTime, $endTime, $step)
    {
        $step *= 60;
        $startTime .= " 08:00:00";
        $endTime .= " 08:00:00";
        $back = array();
        $notEmpty= "select tm from lab_st_pptn_r where stcd='{$stcd}' and tm > '{$startTime}' and tm <= '{$endTime}'";
        $notEmpty = $this->query($notEmpty);
        if (!empty($notEmpty)) {
            while($endTime > $startTime) {
                $nextTime = date("Y-m-d H:i:s", strtotime("$startTime + $step min"));
                $sql = "select sum(drp) as sum_drp from lab_st_pptn_r where stcd='{$stcd}' and tm > '{$startTime}' and tm <= '{$nextTime}'";
                $indexStartTime = substr($startTime, -8, 5);
                $indexEndTime = substr($nextTime, -8, 5);
                $indexDate = substr($startTime, 0, 10);
                $data = $this->query($sql);
                $back[$indexDate]["$indexStartTime-$indexEndTime"] = $data[0]['sum_drp'];
                $startTime = $nextTime;
            }
            //array_pop($back);
            return $back;
        } else {
            return array();
        }
    }
}