<?php
App::uses('AppModel', 'Model');
/**
 * Recipe Model
 *
 */
class Power extends AppModel
{

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'power';

    /**
     * Display field
     *
     * @var string
     */
//    public $displayField = 'name';
//
//    public $belongsTo = array('User' => array('className' => 'User',
//        'foreignKey' => 'user_id',
//        'conditions' => '',
//        'fields' => array('User.id', 'User.name'),
//        'order' => '')
//    );
//
//    public $hasMany = array('RecipeIngredient' => array('className' => 'RecipeIngredient',
//                                                        ));

    public $belongsTo = array('PowerMeters' => array('className' => 'PowerMeters',
        'foreignKey' => 'device_id',
        'conditions' => '',
        'fields' => '', // array('User.id', 'User.name'),
        'order' => '')
    );

    public function getLastMeters(){

        $last_meters = $this->find('all', array('group'=>array('Power.date', 'Power.device_id'),
                                        'order'=>array('Power.date'=>'DESC'),
                                        'limit'=>10));
        $result = array();
        foreach($last_meters as $last_meter){
            unset($last_meter['Power']['id'], $last_meter['PowerMeters']['id']);
            $result[$last_meter['Power']['device_id']] = $last_meter['Power'];
            $result[$last_meter['Power']['device_id']]['name'] = $last_meter['PowerMeters']['name'];
            $result[$last_meter['Power']['device_id']]['status'] = $last_meter['PowerMeters']['status'];
        }
        return $result;
    }

    public function getLastDayRecords(){

//        SELECT  DATE_FORMAT(`date`, '%Y-%m-%d %H:%i') AS fdate, `date`, `power`, device_id FROM `my_power`
//        WHERE `quality` = 192 AND `date` BETWEEN '2014-12-01 00:00:00' AND '2015-01-28 23:59:59'
        $date = new DateTime();
        $date->sub(new DateInterval('P1D'));
        $from = $date->format("Y-m-d H:i:s");     //
        $to = date("Y-m-d H:i:s");
        $last_meters = $this->find('all', array('fields'=>array('Power.device_id', "DATE_FORMAT(`date`, '%Y-%m-%d %H:%i') AS fdate", 'Power.power', 'Power.quality'),  //, 'Power.device_id'
            'order'=>array('fdate'=>'ASC', 'Power.device_id' =>'ASC'),
            'conditions' => array("Power.date BETWEEN '$from' AND '$to' ", 'and'=>array('Power.quality' => CONNECT_ACTIVE)), // 'Power.quality' => CONNECT_ACTIVE, 'AND' => array( ) // ),//
//            'limit'=>10
        ));
        $result = array();
//        foreach($last_meters as $last_meter){
////            unset($last_meter['Power']['id'], $last_meter['PowerMeters']['id']);
////            $myDateTime = new DateTime($last_meter['Power']['date']);
////            $myDateTime->format('Y/m/d H:i:s');
////            $myDateTime->format('D M d Y H:i:s T') YYYY/MM/DD HH:MM:SS strtotime($last_meter['Power']['date'])
////            $result[] = [ $last_meter[0]['fdate'] => [$last_meter['Power']['device_id'] => floatval($last_meter['Power']['power'])]];
//            if ($last_meter['Power']['quality'] != CONNECT_ACTIVE)
//                $last_meter['Power']['power'] = 0;
//
//            $result[strtotime($last_meter[0]['fdate'])][$last_meter['Power']['device_id']] = floatval($last_meter['Power']['power']);
////            $result[$last_meter['Power']['device_id']]['name'] = $last_meter['PowerMeters']['name'];
////            $result[$last_meter['Power']['device_id']]['status'] = $last_meter['PowerMeters']['status'];
//        }
//        $csv = array();
//        foreach($result as $key => $res){
//            $tmp = $res;
//            array_unshift($tmp, $key);
//            $csv[] = implode(',',$tmp);
//        }
//        $res_str = '"Date,1.Формовка,2.Механообробка,3.ГЗН,4.Термопласт авт.,5.Вибивка,6.Гальваніка,7.Бункерна,8.Зборка-Пайка акумуляторів,9.Рем.дільниця,10.Зварочна дільниця" + "';
//        $res_str .= implode('" + "', $csv).'"';
//        var_dump($res_str);die;

//        $result[] = array('Date','1.Формовка');
//echo gmdate('D M d Y H:i:s T', time());
        foreach($last_meters as $last_meter){
//            unset($last_meter['Power']['id'], $last_meter['PowerMeters']['id']);
//            $myDateTime = new DateTime($last_meter['Power']['date']);
//            $myDateTime->format('Y/m/d H:i:s');
//            $myDateTime->format('D M d Y H:i:s T') YYYY/MM/DD HH:MM:SS strtotime($last_meter['Power']['date'])
//            if ($last_meter[0]['fdate'])
//            $result[] = [strtotime($last_meter[0]['fdate'])*1000,floatval($last_meter['Power']['power'])];
            if ($last_meter[0]['fdate'])
            $result[strtotime($last_meter[0]['fdate'])*1000][$last_meter['Power']['device_id']] = $last_meter['Power']['power']; //floatval($last_meter['Power']['power']);
//            $result[$last_meter['Power']['device_id']]['name'] = $last_meter['PowerMeters']['name'];
//            $result[$last_meter['Power']['device_id']]['status'] = $last_meter['PowerMeters']['status'];
        }
       // $res[] = array();


//        var_dump($result);die;
        foreach($result as $key => $val){
            $tmp = $val;
            if (count($tmp) < NUMBER_OF_COUNTERS + 1){
                for ($i = 1; $i < NUMBER_OF_COUNTERS +1; $i++)
                    if (empty($tmp[$i]))
                        $tmp[$i] = 0;
            }
            array_unshift($tmp, $key);
            $res[] = $tmp;
        }
//        var_dump($res);die;
        return $res;
    }

    public function getLastYears(){
        $datas = $this->find('all', array(
            'fields'=>array("DATE_FORMAT(Power.date, '%Y-%m') AS date_per_mounth","(MAX(Power.energy) - MIN(Power.energy)) AS energy_per_mounth", 'Power.device_id', 'PowerMeters.name'),
            'conditions' => array('Power.quality' => CONNECT_ACTIVE),
            'group'=>array('date_per_mounth', 'Power.device_id'),
            'recursive' => 1,
//            'order'=>array('Power.date'=>'DESC'),
//            'limit'=>10
        ));
//        SELECT DATE_FORMAT(`date`, '%Y-%m') AS ym, (MAX(energy) - MIN(energy)) AS min_en, id_dev FROM `power`
//        WHERE `quality` = 192
//        GROUP BY ym,id_dev
        $res =array();
        $result =array();
        $months = array();
//        var_dump($datas);die;
        foreach ($datas as $data) {
            $dd = $data[0]['date_per_mounth'];
            if (empty($months[$dd])) {
                $months[$dd] = $dd;
            }
        }
        $months_title = array();
        foreach($months as $m2){
            $months_title[] = array('title' => $m2.'<br>kW*h');
        }

        foreach ($datas as $data){
            $d = $data['Power']['device_id']-1;
//            $res[]= [$data['Power']['device_id'],$data['PowerMeters']['name'], $data[0]['energy_per_mounth']];
//            $res[]= ['id' => $data['Power']['device_id'], 'name' => $data['PowerMeters']['name']];
//            $res[$d]['id']= $data['Power']['device_id'];
//            $res[$d]['name']= $data['PowerMeters']['name'];
//            $res[$d][$data[0]['date_per_mounth']]= $data[0]['energy_per_mounth'];


//            if (isset($res[$d])){
//                $res[$d][0][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
//            }  else {
//                $res[$d][0] = [$data['Power']['device_id'],$data['PowerMeters']['name']];
//                foreach($months as $m){
//                    $res[$d][0][$m] = 0; //'n/a';
//                }
//                $res[$d][0][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
//            }

            if (isset($res[$d])){
                $res[$d][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
            }  else {
                $res[$d] = [$data['Power']['device_id'],$data['PowerMeters']['name']];
                foreach($months as $m){
                    $res[$d][$m] = 0; //'n/a';
                }
                $res[$d][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
            }




        }

        ksort($res);
        $r = array();
        foreach($res as $res1) {
            foreach ($res1 as $r2) {
                $tmp[] = $r2;
            }
            $r[] = $tmp;
            unset($tmp);
        }

//        var_dump($r);
        $result['title'] = $months_title;
        $result['data'] = $r;
        $result['months'] = $months;
        return $result;
    }

    public function getConsumedEnergy($from, $to)
    {
        $datas = $this->find('all', array(
            'fields' => array('Power.device_id', "(MAX(Power.energy) - MIN(Power.energy)) AS consumed_energy", ),
            'conditions' => array('Power.quality' => CONNECT_ACTIVE, 'AND' => array("Power.date BETWEEN '$from' AND '$to' ")),
            'group' => array('Power.device_id'),
            'recursive' => 1,
//            'order'=>array('Power.date'=>'DESC'),
//            'limit'=>10
        ));
        $res = array();
        foreach($datas as $d){
            $res[$d['Power']['device_id']] = $d[0]['consumed_energy'];
        }
        if (count($res) < NUMBER_OF_COUNTERS){
            for ($i = 1; $i < NUMBER_OF_COUNTERS; $i++)
                if (empty($res[$i]))
                    $res[$i] = 0;
        }

//        echo '$from:'.$from.'- $to:'.$to.'<br>';
//        var_dump($res);//die;
        return $res;
    }

//    public function

}
