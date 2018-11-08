<?php

/** ===================
 *  user.model.php
 *  ===================
 */

class UserModel extends Database {
    const TABLE_DEVICE = 'device';
    const TABLE_IP = 'ip';
    const TABLE_USER = 'user';
    const TABLE_ORG = 'org';


    public $id = null;
    public $fingerprint = null;
    public $view_count = null;
    public $status = null;
    public $is_enabled = null;
    public $date_created = null;
    public $date_modified = null;

    public $user_users = Array();

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_fingerprint($id)
    {
        $this->fingerprint = $id;
    }


    public function set_status($data)
    {
        $this->status = $data;
    }

    public function set_is_enabled($data)
    {
        $this->is_enabled = $data;
    }

    public function set_view_count($data)
    {
        $this->view_count = $data;
    }

    public function set_date_created($date)
    {
        $this->date_created = $date;
    }

    public function increment_view_count()
    {
        $this->view_count++;
    }

    public function set_date_modified($date)
    {
        $this->date_modified = $date;
    }

    public function serialize_object($type=SERIALIZE_DATABASE)
    {
        $data = Array(
            'user_id'          => $this->id,

            'user_fingerprint'  => $this->fingerprint,
            'user_view_count'   => $this->view_count,
            'user_is_enabled' => $this->is_enabled,
            'user_status'      => $this->status,
            'user_tcreate'     => $this->date_created,
            'user_tmodified'   => $this->date_modified
        );

        switch($type)
        {
            case SERIALIZE_JSON:
                return json_encode($data);
                break;

            case SERIALIZE_DATABASE:
            default:
                return $data;
                break;
        }
    }



    public function __construct($user = null)
    {
        /** ===================
         *  LOAD FROM OBJECT ID
         *  ===================
         *  If an user ID is provided, lets fetch the data for this particular object
         */
        if($user != null && is_numeric($user))
        {
            $user_id = $user;
            $db_conditions = Array();
            $db_conditions['user_id'] = $user_id;

            $db_columns = array(
                'user_id',
                'user_fingerprint',
                'user_view_count',
                'user_is_enabled',
                'user_status',
                'user_tcreate',
                'user_tmodified'
            );

            $result = $this->db_retrieve(self::TABLE_USER,$db_columns,$db_conditions,null,false);
            if(empty($result[0]))
                throw new Exception('user ID ' . $user_id . ' is not a valid user_id.');

            $this->set_id($user_id);
            $this->set_fingerprint($result[0]['user_fingerprint']);
            $this->set_fingerprint($result[0]['user_view_count']);

            $this->set_fingerprint($result[0]['user_is_enabled']);

            $this->set_status($result[0]['user_status']);
            $this->set_date_created($result[0]['user_tcreate']);
            $this->set_date_modified($result[0]['user_tmodified']);


        } elseif(is_array($user))
        {
            /** =============================
             *  NEW OBJECT FROM ARRAY OF DATA
             *  =============================
             *  If an array off data is being loaded, then lets go ahead and load them into the object
             */

            foreach($user as $key=>$val)
            {
                if($key == 'user_id')              $this->set_id($val);
                if($key == 'user_fingerprint')     $this->set_fingerprint($val);
                if($key == 'user_view_count')     $this->set_view_count($val);
                if($key == 'user_is_enabled')     $this->set_is_enabled($val);
                if($key == 'user_status')          $this->set_status($val);
                if($key == 'user_tcreate')         $this->set_date_created($val);
                if($key == 'user_tmodified')       $this->set_date_modified($val);
            }
        }
    }



    public function update_user($user = null)
    {

        $user_id = null;
        $db_columns = Array();

        if($user == null && !is_numeric($this->id))
            throw new Exception('You must provide a user_id or set a user ID to this user object.');
        if(!is_array($user) && $user instanceof UserModel) $user = $user->id;

        /**
         *  This method can either take an array of valid user table columns
         *  and store it, if it is not provided, it will assume to save all
         *  the properties within the object
         */

        if($user != null && is_array($user))
        {
            $user_id = $this->id;
            $data = $user;
            foreach($data as $key=>$val)
            {
                if($key == 'user_fingerprint')  $db_columns[$key] = $val;
                if($key == 'user_view_count')  $db_columns[$key] = $val;
                if($key == 'user_is_enabled')  $db_columns[$key] = $val;
                if($key == 'user_status')       $db_columns[$key] = $val;
                if($key == 'user_tcreate')      $db_columns[$key] = $val;
                if($key == 'user_tmodified')    $db_columns[$key] = $val;
            }
        } elseif($user != null && is_numeric($user))
        {
            $user_id = $user;
            $this->id = $user_id;
            /**
             *  No array data provided, then lets just save the properties within the object
             */
            if($this->view_count != null)      $db_columns['user_view_count'] = $this->view_count;
            if($this->is_enabled != null)      $db_columns['user_is_enabled'] = $this->is_enabled;
            if($this->fingerprint != null)      $db_columns['user_fingerprint'] = $this->fingerprint;
            if($this->status != null)           $db_columns['user_status'] = $this->status;
            $db_columns['user_tmodified'] = current_timestamp();
        }

        if(empty($db_columns))
            throw new Exception('No data provided to update user');

        $db_conditions = array('user_id'=>$user_id);

        try {
            $this->db_update(self::TABLE_USER,$db_columns,$db_conditions,false);
        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
    }


    public function add_user($user = null)
    {
        /**
         *  $user should be a user object being passed
         */

        if($user instanceof User)
        {
            $db_columns =  $user->serialize_object();
            if(!isset($db_columns['user_id'])) $db_columns['user_id'] = $this->id;
        } else {
            throw new Exception('Not a valid user object!' . print_r($user,true));
        }

        if(isset($db_columns['user_id'])) unset($db_columns['user_id']);

        try {
            $insert_id = $this->db_create(self::TABLE_USER,$db_columns);
            $this->set_id($insert_id);
            return $insert_id;

        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
        return false;
    }


    public static function get_user_by_fingerprint($user_fingerprint=null)
    {
        /**
         *  RETURNS OBJECT
         */
        if($user_fingerprint == null)
            throw new Exception('User identifier provided must be a user_fingerprint');


        /*/$db_conditions = Array('user_fingerprint'=>'"' . $user_fingerprint . '"');


        $db_columns = array(
            'user_id',
            'user_fingerprint',
            'user_view_count',
            'user_is_enabled',
            'user_status',
            'user_tcreate',
            'user_tmodified'
        );*/

        $db_instance = new Database();

        $result = $db_instance->db_query('SELECT user_id,user_fingerprint,user_view_count, user_is_enabled,user_status,user_tcreate,user_tmodified FROM user WHERE user_fingerprint="' . $user_fingerprint . '";');
        //$result = $db_instance->db_retrieve(self::TABLE_USER,$db_columns,$db_conditions,null,false);
        unset($db_instance);
        if(empty($result[0]))
            return false;
        else return new User($result[0]);

    }
}




