<?php

/** ===================
 *  ip.model.php
 *  ===================
 */

class IPModel extends Database {
    const TABLE_DEVICE = 'device';
    const TABLE_IP = 'ip';
    const TABLE_USER = 'user';
    const TABLE_ORG = 'org';


    public $id = null;
    public $org_id = null;
    public $device_id = null;
    public $user_id = null;


    public $ip_address = null;
    public $country = null;
    public $city = null;
    public $postal_code = null;
    public $location = null;
    public $url = null;
    public $campaign_id = null;
    public $zone_id = null;

    public $hostname = null;

    public $domain = null;
    public $metro_code = null;
    public $category = null;
    public $connection = null;

    public $referrer = null;

    public $timezone = null;
    
    public $status = null;
    public $is_enabled = null;
    public $is_mraid = null;
    public $date_created = null;
    public $date_modified = null;

    public $device_object = null;
    public $user_object = null;
    public $org_object = null;

    public $note = null;
    public $asn = null;
    public $asn_name = null;
    public $is_monitor = null;
    public $accept_header = null;

    public $campaign_click_id = null;




    public function set_note($data) { $this->note = $data;}
    public function set_asn($data) { $this->asn = $data;}
    public function set_asn_name($data) { $this->asn_name = $data;}
    public function set_is_monitor($data) { $this-> is_monitor = $data;}

    public function set_campaign_click_id($data) { $this->campaign_click_id = $data;}

    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_org_id($id)
    {
        $this->org_id = $id;
    }
    public function set_campaign_id($id)
    {
        $this->campaign_id = $id;
    }

    public function set_zone_id($id)
    {
        $this->zone_id = $id;
    }

    public function set_user_id($id)
    {
        $this->user_id = $id;
    }

    public function set_accept_header($data)
    {
        $this->accept_header = $data;
    }

    public function set_hostname($data)
    {
        $this->hostname = $data;
    }

    public function set_referrer($data)
    {
        $this->referrer = $data;
    }

    public function set_is_mraid($data)
    {
        $this->is_mraid = $data;
    }

    public function set_device_id($id)
    {
        $this->device_id = $id;
    }

    public function set_ip_address($data)
    {
        $this->ip_address = $data;
    }

    public function set_country($data)
    {
        $this->country = $data;
    }
    public function set_city($data)
    {
        $this->city = $data;
    }

    public function set_postal_code($data)
    {
        $this->postal_code = $data;
    }
    public function set_location($data)
    {
        $this->location = $data;
    }

    public function set_url($data)
    {
        $this->url = $data;
    }

    public function set_domain($data)
    {
        $this->domain = $data;
    }

    public function set_metro_code($data)
    {
        $this->metro_code = $data;
    }

    public function set_category($data)
    {
        $this->category = $data;
    }

    public function set_connection($data)
    {
        $this->connection = $data;
    }

    public function set_is_enabled($data)
    {
        $this->is_enabled = $data;
    }

    public function set_status($data)
    {
        $this->status = $data;
    }

    public function set_timezone($data)
    {
        $this->timezone = $data;
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
            'ip_id'             => $this->id,
            'user_id'           => $this->user_id,
            'org_id'            => $this->org_id,
            'device_id'         => $this->device_id,

            'ip_address'        => $this->ip_address,
            'ip_hostname'       => $this->hostname,
            'ip_country'        => $this->country,
            'ip_city'           => $this->city,
            'ip_location'       => $this->location,
            'ip_postal_code'    => $this->postal_code,
            'ip_domain'         => $this->domain,
            'ip_metro_code'     => $this->metro_code,
            'ip_category'       => $this->category,
            'ip_connection'     => $this->connection,
            'ip_url'            => $this->url,
            'ip_referrer'       => $this->referrer,
            'ip_campaign_id'    => $this->campaign_id,
            'ip_zone_id'        => $this->zone_id,
            'ip_is_mraid'       => $this->is_mraid,
            'ip_timezone'       => $this->timezone,

            'ip_note'           => $this->note,
            'ip_asn'            =>$this->asn,
            'ip_asn_name'      =>$this->asn_name,
            'ip_is_monitor'     =>$this->is_monitor,
            'ip_accept_header'  =>$this->accept_header,
            'ip_campaign_click_id' => $this->campaign_click_id,



            'ip_status'         => $this->status,
            'ip_is_enabled'     => $this->is_enabled,
            'ip_tcreate'        => $this->date_created,
            'ip_tmodified'      => $this->date_modified
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



    public function __construct($ip = null)
    {
        /** ===================
         *  LOAD FROM OBJECT ID
         *  ===================
         *  If an ip ID is provided, lets fetch the data for this particular object
         */
        if($ip != null && is_numeric($ip))
        {
            $ip_id = $ip;
            $db_conditions = Array();
            $db_conditions['ip_id'] = $ip_id;

            $db_columns = array(
                'ip_id',
                'user_id',
                'org_id',
                'device_id',
                'ip_address',
                'ip_hostname',
                'ip_country',
                'ip_city',
                'ip_location',
                'ip_postal_code',
                'ip_domain',
                'ip_metro_code',
                'ip_category',
                'ip_connection',
                'ip_url',
                'ip_timezone',
                'ip_referrer',
                'ip_campaign_id',
                'ip_zone_id',
                'ip_is_mraid',
                'ip_status',
                'ip_is_enabled',
                'ip_tmodified',
                'ip_create',


                'ip_note' ,
                'ip_asn',
                'ip_asn_name',
                'ip_is_monitor',
                'ip_accept_header',
                'ip_campaign_click_id'


            );
            $result = $this->db_retrieve(self::TABLE_IP,$db_columns,$db_conditions,null,false);
            if(empty($result[0]))
                throw new Exception('ip ID ' . $ip_id . ' is not a valid ip_id.');

            $this->set_id($ip_id);
            $this->set_user_id($result[0]['user_id']);
            $this->set_org_id($result[0]['org_id']);
            $this->set_device_id($result[0]['device_id']);
            $this->set_ip_address($result[0]['ip_address']);
            $this->set_campaign_id($result[0]['ip_campaign_id']);
            $this->set_is_mraid($result[0]['ip_is_mraid']);
            $this->set_zone_id($result[0]['ip_zone_id']);
            $this->set_hostname($result[0]['ip_hostname']);
            $this->set_country($result[0]['ip_country']);
            $this->set_city($result[0]['ip_city']);
            $this->set_accept_header($result[0]['ip_accept_header']);
            $this->set_location($result[0]['ip_location']);
            $this->set_postal_code($result[0]['ip_postal_code']);
            $this->set_url($result[0]['ip_url']);
            $this->set_domain($result[0]['ip_domain']);
            $this->set_metro_code($result[0]['ip_metro_code']);
            $this->set_category($result[0]['ip_category']);
            $this->set_connection($result[0]['ip_connection']);
            $this->set_referrer($result[0]['ip_referrer']);
            $this->set_timezone($result[0]['ip_timezone']);
            $this->set_status($result[0]['ip_status']);
            $this->set_is_enabled($result[0]['ip_is_enabled']);
            $this->set_date_created($result[0]['ip_tcreate']);
            $this->set_date_modified($result[0]['ip_tmodified']);
            $this->set_campaign_click_id($result[0]['ip_campaign_click_id']);


            $this->set_note($result[0]['ip_note']);
            $this->set_asn($result[0]['ip_asn']);
            $this->set_asn_name($result[0]['ip_asn_name']);
            $this->set_is_monitor($result[0]['ip_is_monitor']);




        } elseif(is_array($ip))
        {
            /** =============================
             *  NEW OBJECT FROM ARRAY OF DATA
             *  =============================
             *  If an array off data is being loaded, then lets go ahead and load them into the object
             */

            foreach($ip as $key=>$val)
            {
                if($key == 'ip_id')             $this->set_id($val);
                if($key == 'user_id')           $this->set_user_id($val);
                if($key == 'org_id')            $this->set_org_id($val);
                if($key == 'device_id')         $this->set_device_id($val);
                if($key == 'ip_address')        $this->set_ip_address($val);
                if($key == 'ip_country')        $this->set_country($val);
                if($key == 'ip_city')           $this->set_city($val);
                if($key == 'ip_location')       $this->set_location($val);
                if($key == 'ip_postal_code')    $this->set_postal_code($val);
                if($key == 'ip_domain')         $this->set_domain($val);
                if($key == 'ip_metro_code')     $this->set_metro_code($val);
                if($key == 'ip_category')       $this->set_category($val);
                if($key == 'ip_url')            $this->set_url($val);
                if($key == 'ip_connection')     $this->set_connection($val);
                if($key == 'ip_referrer')       $this->set_referrer($val);
                if($key == 'ip_campaign_id')    $this->set_campaign_id($val);
                if($key == 'ip_zone_id')    $this->set_zone_id($val);
                if($key == 'ip_is_mraid')       $this->set_is_mraid($val);
                if($key == 'ip_accept_header')  $this->set_accept_header($val);
                if($key == 'ip_timezone')       $this->set_timezone($val);

                if($key == 'ip_hostname')       $this->set_hostname($val);
                if($key == 'ip_status')         $this->set_status($val);
                if($key == 'ip_is_enabled')     $this->set_is_enabled($val);
                if($key == 'ip_tcreate')        $this->set_date_created($val);
                if($key == 'ip_tmodified')      $this->set_date_modified($val);


                if($key == 'ip_note')           $this->set_note($val);
                if($key == 'ip_asn')            $this->set_asn($val);
                if($key == 'ip_asn_name')       $this->set_asn_name($val);
                if($key == 'ip_is_monitor')     $this->set_is_monitor($val);

                if($key == 'ip_campaign_click_id') $this->set_campaign_click_id($val);
            }
        }
    }



    public function update_ip($ip = null)
    {
        $ip_id = null;
        $db_columns = Array();

        if($ip == null && !is_numeric($this->id))
            throw new Exception('You must provide a ip_id or set a ip ID to this ip object.');
        if(!is_array($ip) && $ip == null) $ip = $this->id;

        /**
         *  This method can either take an array of valid ip table columns
         *  and store it, if it is not provided, it will assume to save all
         *  the properties within the object
         */

        if($ip != null && is_array($ip))
        {
            $ip_id = $this->id;
            $data = $ip;
            foreach($data as $key=>$val)
            {
                if($key == 'user_id')           $db_columns[$key] = $val;
                if($key == 'org_id')            $db_columns[$key] = $val;
                if($key == 'device_id')         $db_columns[$key] = $val;
                if($key == 'ip_address')        $db_columns[$key] = $val;
                if($key == 'ip_country')        $db_columns[$key] = $val;
                if($key == 'ip_city')           $db_columns[$key] = $val;
                if($key == 'ip_location')       $db_columns[$key] = $val;
                if($key == 'ip_postal_code')    $db_columns[$key] = $val;
                if($key == 'ip_domain')         $db_columns[$key] = $val;
                if($key == 'ip_metro_code')     $db_columns[$key] = $val;
                if($key == 'ip_campaign_id')    $db_columns[$key] = $val;
                if($key == 'ip_zone_id')        $db_columns[$key] = $val;
                if($key == 'ip_is_mraid')       $db_columns[$key] = $val;
                if($key == 'ip_category')       $db_columns[$key] = $val;
                if($key == 'ip_timezone')       $db_columns[$key] = $val;
                if($key == 'ip_url')            $db_columns[$key] = $val;
                if($key == 'ip_connection')     $db_columns[$key] = $val;
                if($key == 'ip_hostname')       $db_columns[$key] = $val;
                if($key == 'ip_referrer')       $db_columns[$key] = $val;
                if($key == 'ip_status')         $db_columns[$key] = $val;
                if($key == 'ip_is_enabled')     $db_columns[$key] = $val;
                if($key == 'ip_accept_header')  $db_columns[$key] = $val;
                if($key == 'ip_tcreate')        $db_columns[$key] = $val;
                if($key == 'ip_tmodified')      $db_columns[$key] = $val;


                if($key == 'ip_note')           $db_columns[$key] = $val;
                if($key == 'ip_asn')            $db_columns[$key] = $val;
                if($key == 'ip_asn_name')       $db_columns[$key] = $val;
                if($key == 'ip_is_monitor')     $db_columns[$key] = $val;

                if($key == 'ip_campaign_click_id') $db_columns[$key]= $val;


            }
        } elseif($ip != null && is_numeric($ip))
        {
            $ip_id = $ip;
            $this->id = $ip_id;
            /**
             *  No array data provided, then lets just save the properties within the object
             */

            if($this->user_id != null)          $db_columns['user_id']  =         $this->user_id;
            if($this->org_id != null)           $db_columns['org_id'] =           $this->org_id;
            if($this->device_id != null)        $db_columns['device_id'] =        $this->device_id;
            if($this->campaign_id !=null)       $db_columns['ip_campaign_id'] =       $this->campaign_id;
            if($this->zone_id !=null)       $db_columns['ip_zone_id'] =       $this->zone_id;
            if($this->is_mraid !=null)          $db_columns['ip_is_mraid'] =        $this->is_mraid;
            if($this->ip_address != null)       $db_columns['ip_address'] =       $this->ip_address;
            if($this->country != null)          $db_columns['ip_country'] =       $this->country;
            if($this->city != null)             $db_columns['ip_city'] =          $this->city;
            if($this->location != null)         $db_columns['ip_location'] =      $this->location;
            if($this->postal_code != null)      $db_columns['ip_postal_code'] =   $this->postal_code;
            if($this->domain != null)           $db_columns['ip_domain'] =        $this->domain;
            if($this->url != null)              $db_columns['ip_url'] =             $this->url;
            if($this->metro_code != null)       $db_columns['ip_metro_code'] =    $this->metro_code;
            if($this->category != null)         $db_columns['ip_category'] =      $this->category;
            if($this->connection != null)       $db_columns['ip_connection'] =    $this->connection;
            if($this->referrer != null)         $db_columns['ip_referrer'] =      $this->referrer;
            if($this->hostname != null)         $db_columns['ip_hostname'] =    $this->hostname;
            if($this->accept_header != null)    $db_columns['ip_accept_header'] = $this->accept_header;
            if($this->timezone !== null)        $db_columns['ip_timezone']      = $this->timezone;

            if($this->campaign_click_id !== null) $db_columns['ip_campaign_click_id'] = $this->campaign_click_id;

            if($this->status != null)           $db_columns['ip_status'] =        $this->status;
            if($this->is_enabled != null)       $db_columns['ip_is_enabled'] =    $this->is_enabled;

            if($this->note != null)             $db_columns['ip_note'] =    $this->note;
            if($this->asn != null)              $db_columns['ip_asn'] =    $this->asn;
            if($this->asn_name != null)         $db_columns['ip_asn_name'] =    $this->asn_name;
            if($this->is_monitor != null)       $db_columns['ip_is_monitor'] =    $this->is_monitor;


            $db_columns['ip_tmodified'] = current_timestamp();
        }

        if(empty($db_columns))
            throw new Exception('No data provided to update ip');

        $db_conditions = array('ip_id'=>$ip_id);

        try {
            $this->db_update(self::TABLE_IP,$db_columns,$db_conditions,false);
        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
    }


    public function add_ip($ip = null)
    {
        /**
         *  $ip should be a ip object being passed
         */

        if($ip instanceof IPModel)
        {
            $db_columns =  $ip->serialize_object();
            if(!isset($db_columns['ip_id'])) $db_columns['ip_id'] = $this->id;
        } else {
            throw new Exception('Not a valid ip object!' . print_r($ip,true));
        }

        if(isset($db_columns['ip_id'])) unset($db_columns['ip_id']);

        try {
            $insert_id = $this->db_create(self::TABLE_IP,$db_columns);
            return $insert_id;

        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
        return false;
    }
}




