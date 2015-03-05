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

        $last_meters = $this->find('all', array('group'=>array('Power.date'),  //, 'Power.device_id'
            'order'=>array('Power.date'=>'DESC'),
            'conditions' => array('Power.device_id' => 6),
            'limit'=>10));
        $result = array();
        $result[] = array('Date','1.Формовка');

        foreach($last_meters as $last_meter){
//            unset($last_meter['Power']['id'], $last_meter['PowerMeters']['id']);
            $result[] = [$last_meter['Power']['date'],$last_meter['Power']['power']];
//            $result[$last_meter['Power']['device_id']]['name'] = $last_meter['PowerMeters']['name'];
//            $result[$last_meter['Power']['device_id']]['status'] = $last_meter['PowerMeters']['status'];
        }
        return $result;
    }

    public function getLastYears(){
        $datas = $this->find('all', array(
            'fields'=>array("DATE_FORMAT(Power.date, '%Y-%m') AS date_per_mounth","(MAX(Power.energy) - MIN(Power.energy)) AS energy_per_mounth", 'Power.device_id', 'PowerMeters.name'),
            'conditions' => array('Power.quality' => 192),
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
            $months_title[] = array('title' => $m2);
        }

        foreach ($datas as $data){
            $d = $data['Power']['device_id'];
//            $res[]= [$data['Power']['device_id'],$data['PowerMeters']['name'], $data[0]['energy_per_mounth']];
//            $res[]= ['id' => $data['Power']['device_id'], 'name' => $data['PowerMeters']['name']];
//            $res[$d]['id']= $data['Power']['device_id'];
//            $res[$d]['name']= $data['PowerMeters']['name'];
//            $res[$d][$data[0]['date_per_mounth']]= $data[0]['energy_per_mounth'];


            if (isset($res[$d])){
//
//
                $res[$d][0][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
            }  else {
                $res[$d][0] = [$data['Power']['device_id'],$data['PowerMeters']['name']];
                foreach($months as $m){
                    $res[$d][0][$m] = 0; //'n/a';
                }
                $res[$d][0][$data[0]['date_per_mounth']] = $data[0]['energy_per_mounth'];
            }




        }

        ksort($res);
        var_dump($res);
        $result['title'] = $months_title;
        $result['data'] = $res;
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
