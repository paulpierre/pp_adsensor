<?php
/** ================
 *  filter.class.php
 *  ================
 *  Audit's whether a user should or should not be allowed
 */

class Filter extends Identify
{

/** +------------+
 *  | CLASS DATA |
 *  +------------+*/
    public $filter_array = Array();

    public function is_verified()
    {
        $user_data = $this->get_all_data();
        //error_log('Dataset: ' . print_r($user_data,true));
        $filter_array = $this->filter_array;
        foreach($filter_array as $k=>$v)
        {
            //error_log('checking key: ' . $k);
            if(isset($user_data[$k]))
            {
                //error_log('found: ' . $k . ' -> ' . $v[1]);
                preg_match($v[1],$user_data[$k],$_matches);
                //error_log(PHP_EOL. 'RESULT:' . print_r($_matches,true));
                $is_match = !empty($_matches);

                $result =  (($is_match && $v[0] == FILTER_FLAG_BLACK_LIST )||(!$is_match && $v[0] == FILTER_FLAG_WHITE_LIST ))?false:true;
                //error_log((($result)?'PASSED':'FAIL') . ' Eval: '. $v[1] . ' - ' .$user_data[$k] . ($v[0] == FILTER_FLAG_BLACK_LIST?' CANNOT match ':' MUST match') . ' preg_result:' . $is_match);
                if(!$result) return $result;
            }
        }
        return true;
    }



    public function set_filter($data)
    {
        if(!empty($data)) $this->filter_array = $data;
        //If this is an array, lets load all the information
    }



    /*
    error_log('checking:' . $k);
    switch($k)
    {
        case 'ip_location':
            $is_match = preg_match($v[1],$this->ip_location);
            error_log('is_match:' . $is_match);
            return (($is_match && $v[0] == FILTER_FLAG_BLACK_LIST )||(!$is_match && $v[0] == FILTER_FLAG_WHITE_LIST ))?false:true;
            //if it's a match and we want to black list them, deny. otherwise it's a
        break;
    }*/

}
