<?php

/** ===================
 *  org.model.php
 *  ===================
 */

class OrgModel extends Database {
    const TABLE_DEVICE = 'device';
    const TABLE_IP = 'ip';
    const TABLE_USER = 'user';
    const TABLE_ORG = 'org';


    public $id = null;
    public $name = null;
    public $domain = null;
    public $type = null;
    public $status = null;
    public $date_created = null;
    public $date_modified = null;


    public $device_object = null;
    public $ip_object = null;
    public $org_object = null;

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_name($id)
    {
        $this->name = $id;
    }


    public function set_status($data)
    {
        $this->status = $data;
    }

    public function set_domain($data)
    {
        $this->domain = $data;
    }

    public function set_type($data)
    {
        $this->type = $data;
    }

    public function set_date_created($date)
    {
        $this->date_created = $date;
    }

    public function set_date_modified($date)
    {
        $this->date_modified = $date;
    }

    public function serialize_object($type=SERIALIZE_DATABASE)
    {
        $data = Array(
            'org_id'        => $this->id,
            'org_name'      => $this->name,
            'org_domain'    => $this->domain,
            'org_type'      => $this->type,
            'org_status'    => $this->status,
            'org_tcreate'   => $this->date_created,
            'org_tmodified' => $this->date_modified
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



    public function __construct($org = null)
    {
        /** ===================
         *  LOAD FROM OBJECT ID
         *  ===================
         *  If an org ID is provided, lets fetch the data for this particular object
         */
        if($org != null && is_numeric($org))
        {
            $org_id = $org;
            $db_conditions = Array();
            $db_conditions['org_id'] = $org_id;

            $db_columns = array(
                'org_id',
                'org_name',
                'org_domain',
                'org_type',
                'org_status',
                'org_tcreate',
                'org_tmodified'
            );

            $result = $this->db_retrieve(self::TABLE_org,$db_columns,$db_conditions,null,false);
            if(empty($result[0]))
                throw new Exception('org ID ' . $org_id . ' is not a valid org_id.');

            $this->set_id($org_id);
            $this->set_name($result[0]['org_name']);
            $this->set_domain($result[0]['org_domain']);
            $this->set_type($result[0]['org_type']);
            $this->set_status($result[0]['org_status']);
            $this->set_date_created($result[0]['org_tcreate']);
            $this->set_date_modified($result[0]['org_tmodified']);


        } elseif(is_array($org))
        {
            /** =============================
             *  NEW OBJECT FROM ARRAY OF DATA
             *  =============================
             *  If an array off data is being loaded, then lets go ahead and load them into the object
             */

            foreach($org as $key=>$val)
            {
                if($key == 'org_id')              $this->set_id($val);
                if($key == 'org_name')     $this->set_name($val);
                if($key == 'org_domain')     $this->set_domain($val);
                if($key == 'org_type')     $this->set_type($val);
                if($key == 'org_status')          $this->set_status($val);
                if($key == 'org_tcreate')         $this->set_date_created($val);
                if($key == 'org_tmodified')       $this->set_date_modified($val);
            }
        }
    }



    public function update_org($org = null)
    {
        $org_id = null;
        $db_columns = Array();

        if($org == null && !is_numeric($this->id))
            throw new Exception('You must provide a org_id or set a org ID to this org object.');
        if(!is_array($org) && $org == null) $org = $this->id;

        /**
         *  This method can either take an array of valid org table columns
         *  and store it, if it is not provided, it will assume to save all
         *  the properties within the object
         */

        if($org != null && is_array($org))
        {
            $org_id = $this->id;
            $data = $org;
            foreach($data as $key=>$val)
            {
                if($key == 'org_name')          $db_columns[$key] = $val;
                if($key == 'org_domain')        $db_columns[$key] = $val;
                if($key == 'org_type')          $db_columns[$key] = $val;
                if($key == 'org_status')        $db_columns[$key] = $val;
                if($key == 'org_tcreate')       $db_columns[$key] = $val;
                if($key == 'org_tmodified')     $db_columns[$key] = $val;
            }
        } elseif($org != null && is_numeric($org))
        {
            $org_id = $org;
            $this->id = $org_id;
            /**
             *  No array data provided, then lets just save the properties within the object
             */
            if($this->name != null)      $db_columns['org_name'] = $this->name;
            if($this->domain != null)      $db_columns['org_domain'] = $this->domain;
            if($this->type != null)      $db_columns['org_type'] = $this->type;
            if($this->status != null)           $db_columns['org_status'] = $this->status;
            $db_columns['org_tmodified'] = current_timestamp();
        }

        if(empty($db_columns))
            throw new Exception('No data provided to update org');

        $db_conditions = array('org_id'=>$org_id);

        try {
            $this->db_update(self::TABLE_ORG,$db_columns,$db_conditions,false);
        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
    }


    public function add_org($org = null)
    {
        /**
         *  $org should be a org object being passed
         */

        if($org instanceof OrgModel)
        {
            $db_columns =  $org->serialize_object();
            if(!isset($db_columns['org_id'])) $db_columns['org_id'] = $this->id;
        } else {
            throw new Exception('Not a valid org object!' . print_r($org,true));
        }

        if(isset($db_columns['org_id'])) unset($db_columns['org_id']);

        try {
            $insert_id = $this->db_create(self::TABLE_ORG,$db_columns);
            return $insert_id;

        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
        return false;
    }


    public static function get_org_id($org_array=null)
    {
        /**
         *  RETURNS OBJECT
         */
        if(!is_array($org_array))
            throw new Exception('Organization identifier provided must be an array with organization data');

        $db_conditions = $org_array;

        $db_columns = array(
            'org_id',
            'org_name',
            'org_domain',
            'org_type',
            'org_status',
            'org_tcreate',
            'org_tmodified'
        );

        $db_instance = new Database();

        $result = $db_instance->db_retrieve(self::TABLE_ORG,$db_columns,$db_conditions,null,false);
        unset($db_instance);
        if(empty($result[0]))
            return false;
        else return $result[0]['org_id'];

    }


}




