<?php
/**
 * Created by PhpStorm.
 * User: Mikhail
 * Date: 12.02.2015
 * Time: 18:29
 */

App::uses('AppController', 'Controller');
/**
 * Ingredients Controller
 *
 * @property Ingredient $Ingredient
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PowersController extends AppController {


    public function index(){


//        $last_meters = $this->Power->getLastMeters();
//        //today
//        $res_today = $this->Power->getConsumedEnergy(date("Y-m-d ")."00:00:00", date("Y-m-d H:i:s"));
//        //yesterday
//        $date = new DateTime();
//        $date->sub(new DateInterval('P1D'));
//        $res_yesterday = $this->Power->getConsumedEnergy($date->format('Y-m-d')." 00:00:00", $date->format('Y-m-d')." 23:59:59"); //'2014-12-01 00:00:00', '2015-01-28 23:59:59');
//        // this week
//        $this_week = strtotime('this week');
//        $this_week_end = $this_week + (UNIX_WEEK - UNIX_DAY);
//        $res_this_week = $this->Power->getConsumedEnergy(date("Y-m-d ", $this_week).' 00:00:00', date("Y-m-d ", $this_week_end).' 23:59:59');
//        // last week
//        $last_week = strtotime('last week');
//        $last_week_end = $last_week + (UNIX_WEEK - UNIX_DAY);
//        $res_last_week = $this->Power->getConsumedEnergy(date("Y-m-d ", $last_week).' 00:00:00', date("Y-m-d ", $last_week_end).' 23:59:59');
//
//        ksort($last_meters);
//
//        $this->set('lastMeters', $last_meters);
    }

    public function report(){
        $result = $this->Power->getLastYears();

        $this->set('statistics', $result);


//        var_dump($result);
    }

    public function getLastYears(){
        $result = $this->Power->getLastYears();
//        var_dump($result);die;
        $recordsTotal = count($result);
//        $output = array("recordsTotal" => 10,                                  //"draw" => $get['draw'] + 1,
//                        "recordsFiltered" => 10, //);
        $output = array(
                    "draw" => 1,
                    "recordsTotal" => $recordsTotal,
                    "recordsFiltered" => $recordsTotal,
                    "aoColumnDefs" => $result['title'], //array(array('sTitle' => "COLUMN1"), array('sTitle' => "COLUMN2")),
                    "aaData" => $result['data']
        );

        echo json_encode($output); //array('Draw'=>1 ,'aaData' =>$last_meters));
        exit;
    }

    public function getLastMeters(){
        $last_meters = $this->Power->getLastMeters();
        ksort($last_meters);
//        var_dump($last_meters);die;
        //today
        $res_today = $this->Power->getConsumedEnergy(date("Y-m-d ")."00:00:00", date("Y-m-d H:i:s"));
//        var_dump($res_today);die;
        //yesterday
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));
        $res_yesterday = $this->Power->getConsumedEnergy($date->format('Y-m-d')." 00:00:00", $date->format('Y-m-d')." 23:59:59"); //'2014-12-01 00:00:00', '2015-01-28 23:59:59');
        // this week
        $this_week = strtotime('this week');
        $this_week_end = $this_week + (UNIX_WEEK - UNIX_DAY);
        $res_this_week = $this->Power->getConsumedEnergy(date("Y-m-d ", $this_week).' 00:00:00', date("Y-m-d ", $this_week_end).' 23:59:59');
        // last week
        $last_week = strtotime('last week');
        $last_week_end = $last_week + (UNIX_WEEK - UNIX_DAY);
        $res_last_week = $this->Power->getConsumedEnergy(date("Y-m-d ", $last_week).' 00:00:00', date("Y-m-d ", $last_week_end).' 23:59:59');
        $img['connect'] = '<img src=\'../img/connect_refresh.png\' width=\'30px\' height=\'30px\' title=\'Дані актуальні\' />';
        $img['disconnect'] = '<img src=\'../img/connect_cross.png\' width=\'30px\' height=\'30px\' title=\'Дані неактуальні\' />';
        $output = array("recordsTotal" => 10,                                  //"draw" => $get['draw'] + 1,
                        "recordsFiltered" => 10,);
        foreach($last_meters as $last_meter){
            $row[]= $last_meter['device_id'];
            $row[]= $last_meter['name'];
            $row[]= ($last_meter['quality'] == CONNECT_ACTIVE ? $img['connect'] : $img['disconnect']).$last_meter['date'];
            $row[]= $last_meter['power'];
            $row[]= $last_meter['energy'];
            $row[]= $res_today[$last_meter['device_id']];
            $row[]= $res_yesterday[$last_meter['device_id']];
            $row[]= $res_this_week[$last_meter['device_id']];
            $row[]= $res_last_week[$last_meter['device_id']];

            $output['aaData'][] = $row;
            unset($row);
        }

//        if ($this->request->is('ajax')){
            echo json_encode($output); //array('Draw'=>1 ,'aaData' =>$last_meters));
            exit;
//        }
    }

    public function getLastDayRecords(){
        $last_meters = $this->Power->getLastDayRecords();
//        var_dump($last_meters);
        echo json_encode($last_meters); //array('Draw'=>1 ,'aaData' =>$last_meters));

//        echo '{
//                "label": "Europe (EU27)",
//                "data": [[1999, 3.0], [2000, 3.9], [2001, 2.0], [2002, 1.2], [2003, 1.3], [2004, 2.5], [2005, 2.0], [2006, 3.1]]
//            }';
//        echo '"Date,1.Формовка,2.Механообробка,3.ГЗН,4.Термопласт авт.,5.Вибивка,6.Гальваніка,7.Бункерна,8.Зборка-Пайка акумуляторів,9.Рем.дільниця,10.Зварочна дільниця \n" + "2015-03-01 00:29:52,0,0,0,0,0,0,0, \n" + "2015-03-01 00:59:52,0,0,34,3,1,0,0, \n" + "2015-03-01 01:29:52,0,0,27,3,1,0,0, \n" + "2015-03-01 01:59:42,0,0,34,0,1,0,0, \n" + "2015-03-01 01:59:52,0,0,33,0,1,0,0, \n" + "2015-03-01 02:29:54,0,0,61,0,1,0,0, \n" + "2015-03-01 02:59:54,0,0,3,3,1,0,0, \n" + "2015-03-01 03:29:54,0,0,23,3,1,0,0, \n" + "2015-03-01 03:59:54,0,0,26,3,1,0,0, \n" + "2015-03-01 04:29:55,0,0,6,3,1,0,0, \n" + "2015-03-01 04:59:53,0,0,49,3,1,0,0, \n" + "2015-03-01 05:29:54,0,0,5,0,1,0,0, \n" + "2015-03-01 05:59:52,0,0,3,3,1,0,0, \n" + "2015-03-01 06:29:52,0,0,62,3,1,0,0, \n" + "2015-03-01 06:59:52,0,0,45,3,1,0,0, \n" + "2015-03-01 07:29:52,0,0,50,0,2,0,0, \n" + "2015-03-01 07:59:55,0,0,50,3,1,0,0, \n" + "2015-03-01 08:29:52,0,0,41,3,1,0,0, \n" + "2015-03-01 08:59:55,0,0,1,3,1,0,0, \n" + "2015-03-01 09:29:52,0,0,12,0,1,0,0, \n" + "2015-03-01 09:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 10:29:53,0,0,1,3,1,0,0, \n" + "2015-03-01 10:59:56,0,0,11,3,1,0,0, \n" + "2015-03-01 11:29:53,0,0,11,3,1,0,0, \n" + "2015-03-01 11:59:51,0,0,1,3,1,0,0, \n" + "2015-03-01 12:29:51,0,0,1,0,1,0,0, \n" + "2015-03-01 12:59:53,0,0,12,3,1,0,0, \n" + "2015-03-01 13:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 13:59:53,0,0,1,3,1,0,0, \n" + "2015-03-01 14:29:51,0,0,1,0,1,0,0, \n" + "2015-03-01 14:59:51,0,0,11,0,1,0,0, \n" + "2015-03-01 15:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 15:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 16:29:54,0,0,11,3,1,0,0, \n" + "2015-03-01 16:59:53,0,0,1,0,1,0,0, \n" + "2015-03-01 17:29:54,0,0,1,0,1,0,0, \n" + "2015-03-01 17:59:54,0,0,1,0,1,0,0, \n" + "2015-03-01 18:29:51,0,0,11,3,1,0,0, \n" + "2015-03-01 18:59:55,0,0,11,0,1,0,0, \n" + "2015-03-01 19:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 19:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 20:29:51,0,0,11,3,1,0,0, \n" + "2015-03-01 20:59:51,0,0,11,3,1,0,0, \n" + "2015-03-01 21:29:51,0,0,1,3,1,0,0, \n" + "2015-03-01 21:59:54,0,0,1,3,1,0,0, \n" + "2015-03-01 22:29:52,0,0,11,3,1,0,0, \n" + "2015-03-01 22:59:52,0,0,11,3,1,0,0, \n" + "2015-03-01 23:29:52,0,0,1,0,1,0,0, \n" + "2015-03-01 23:59:53,0,0,1,3,1,0,0, \n" + "2015-03-02 00:29:53,0,0,12,3,1,0,0, \n" + "2015-03-02 00:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 01:29:52,0,0,1,3,1,0,0, \n" + "2015-03-02 01:59:52,0,0,11,3,1,0,0, \n" + "2015-03-02 02:29:53,0,0,1,3,1,0,0, \n" + "2015-03-02 02:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 03:29:50,0,0,12,3,1,0,0, \n" + "2015-03-02 03:59:50,0,0,1,3,1,0,0, \n" + "2015-03-02 04:29:53,0,0,11,0,1,0,0, \n" + "2015-03-02 04:59:53,0,0,11,3,1,0,0, \n" + "2015-03-02 05:29:53,0,0,1,3,1,0,0, \n" + "2015-03-02 05:59:50,0,0,1,0,1,0,0, \n" + "2015-03-02 06:29:50,0,0,12,3,1,0,0, \n" + "2015-03-02 06:59:52,0,0,1,3,1,0,0, \n" + "2015-03-02 07:29:53,0,0,1,0,1,0,0, \n" + "2015-03-02 07:59:53,0,0,6,3,1,0,0, \n" + "2015-03-02 08:29:51,0,0,1,3,1,25,0, \n" + "2015-03-02 08:59:50,0,0,41,0,2,24,0, \n" + "2015-03-02 09:29:50,0,11,60,5,1,24,0, \n" + "2015-03-02 09:59:49,0,10,32,8,2,25,1,0 \n" + "2015-03-02 10:29:49,0,4,32,8,4,25,1,0 \n" + "2015-03-02 10:59:49,0,4,59,8,2,25,1,0 \n" + "2015-03-02 11:29:51,0,10,32,9,4,32,1,0 \n" + "2015-03-02 11:59:49,0,8,50,7,4,32,1,0 \n" + "2015-03-02 12:29:49,0,18,42,7,4,27,1,0 \n" + "2015-03-02 12:59:50,0,1,31,0,3,26,0,0 \n" + "2015-03-02 13:29:50,0,2,43,0,3,24,0,0 \n" + "2015-03-02 13:59:50,0,8,44,1,4,18,1,0 \n" + "2015-03-02 14:29:49,0,2,53,1,4,13,1,0 \n" + "2015-03-02 15:00:19,0,2,44,1,4,17,1,0 \n" + "2015-03-02 15:30:18,0,10,44,1,3,38,1,1 \n" + "2015-03-02 16:00:18,0,2,44,4,4,40,1,1 \n"';
        exit;

    }


}