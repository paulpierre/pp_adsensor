<?php

/** ===================
 *  device.model.php
 *  ===================
 */

class DeviceModel extends Database {
    const TABLE_DEVICE = 'device';
    const TABLE_IP = 'ip';
    const TABLE_USER = 'user';
    const TABLE_ORG = 'org';


    public $id = null;
    public $user_id = null;

    public $identifier = null;
    public $identifier_type = null;
    public $mac_address = null;
    public $user_agent = null;
    public $heuristic = null;
    public $ontouchstart = null;
    public $pixel_ratio = null;
    public $color_depth = null;
    public $screen_width = null;
    public $screen_height = null;
    public $browser = null;
    public $os = null;
    public $history_length = null;
    public $view_count = null;
    public $timestamp = null;
    public $audio_context = null;
    public $qc = null;

    public $hardware_concurrency = null;
    public $maxtouchpoints = null;
    public $createtouch = null;
    public $onorientationchange = null;
    public $orientation = null;
    public $locale = null;
    public $plugins = null;
    public $mimetypes = null;
    public $nav_connection = null;
    public $duration = null;

    //NEW STUFF
    public $ss_qc = null;
    public $platform = null;
    public $timezone = null;
    public $character_set = null;
    public $os_version = null;
    public $browser_version = null;
    public $is_bot = null;


    public $dnt = null;
    public $adblock = null;
    public $cookies_enabled = null;
    public $fonts = null;
    public $indexed_db = null;
    public $local_storage = null;
    public $open_db = null;
    public $session_storage = null;
    public $webgl = null;
    public $flag_browser = null;
    public $flag_language = null;
    public $flag_os = null;
    public $flag_resolution = null;

    public $session_twitter = null;
    public $session_reddit = null;
    public $session_facebook = null;
    public $session_google = null;
    public $session_amazon = null;
    public $session_googleplus = null;

    public $gyro_qc = null;
    public $gyro_alpha = null;
    public $gyro_beta = null;
    public $gyro_gamma = null;

    public $dev_tool = null;



    public $date_created = null;
    public $date_modified = null;

    public $ip_object = null;
    public $user_object = null;



    public function set_dnt($data) { $this->dnt = $data; }
    public function set_adblock($data) { $this->adblock = $data; }
    public function set_cookies_enabled($data) { $this->cookies_enabled = $data; }
    public function set_fonts($data) { $this->fonts = $data; }
    public function set_indexed_db($data) { $this->indexed_db = $data; }
    public function set_local_storage($data) { $this->local_storage = $data; }
    public function set_open_db($data) { $this->open_db = $data; }
    public function set_session_storage($data) { $this->session_storage = $data; }
    public function set_webgl($data) { $this->webgl = $data; }
    public function set_flag_browser($data) { $this->flag_browser = $data; }
    public function set_flag_language($data) { $this->flag_language = $data; }
    public function set_flag_os($data) { $this->flag_os = $data; }
    public function set_flag_resolution($data) { $this->flag_resolution = $data; }

    public function set_session_twitter($data) { $this->session_twitter= $data; }
    public function set_session_reddit($data) { $this->session_reddit = $data; }
    public function set_session_facebook($data) { $this->session_facebook = $data; }
    public function set_session_google($data) { $this->session_google = $data; }
    public function set_session_amazon($data) { $this->session_amazon = $data; }
    public function set_session_googleplus($data) { $this->session_googleplus = $data; }

    public function set_gyro_qc($data) { $this->gyro_qc = $data;}
    public function set_gyro_alpha($data) { $this->gyro_alpha = $data; }
    public function set_gyro_beta($data) { $this->gyro_beta = $data; }
    public function set_gyro_gamma($data) { $this->gyro_gamma = $data; }

    public function set_dev_tool($data) { $this->dev_tool = $data; }


    public function set_id($id)
    {
        $this->id = $id;
    }

    public function set_user_id($id)
    {
        $this->user_id = $id;
    }

    public function set_identifier($data)
    {
        $this->identifier = $data;
    }

    public function set_identifier_type($data)
    {
        $this->identifier_type = $data;
    }

    public function set_mac_address($data)
    {
        $this->mac_address = $data;
    }
    public function set_user_agent($data)
    {
        $this->user_agent = $data;
    }

    public function set_view_count($data)
    {
        $this->view_count = $data;
    }

    public function set_heuristic($data)
    {
        $this->heuristic = $data;
    }
    public function set_ontouchstart($data)
    {
        $this->ontouchstart = $data;
    }


    public function set_pixel_ratio($data)
    {
        $this->pixel_ratio = $data;
    }

    public function set_color_depth($data)
    {
        $this->color_depth = $data;
    }

    public function set_screen_width($data)
    {
        $this->screen_width = $data;
    }

    public function set_screen_height($data)
    {
        $this->screen_height = $data;
    }

    public function set_browser($data)
    {
        $this->browser = $data;
    }



    public function set_ss_qc($data){$this->ss_qc = $data;}
    public function set_platform($data){$this->platform = $data;}
    public function set_timezone($data){$this->timezone = $data;}
    public function set_character_set($data){$this->character_set = $data;}
    public function set_os_version($data){$this->os_version = $data;}
    public function set_browser_version($data){$this->browser_version = $data;}
    public function set_is_bot($data){$this->is_bot = $data;}


    public function set_os($data)
    {
        $this->os = $data;
    }

    public function set_timestamp($data)
    {
        $this->timestamp = $data;
    }

    public function set_audio_context($data)
    {
        $this->audio_context = $data;
    }

    public function set_qc($data)
    {
        $this->qc = $data;
    }

    public function set_history_length($data)
    {
        $this->history_length = $data;
    }

    public function increment_view_count()
    {
        $this->view_count++;
    }

    public function set_date_created($date)
    {
        $this->date_created = $date;
    }

    public function set_date_modified($date)
    {
        $this->date_modified = $date;
    }


    public function set_hardware_concurrency($data)
    {
        $this->hardware_concurrency = $data;
    }

    public function set_maxtouchpoints($data)
    {
        $this->maxtouchpoints = $data;
    }

    public function set_createtouch($data)
    {
        $this->createtouch = $data;
    }

    public function set_onorientationchange($data)
    {
        $this->onorientationchange = $data;
    }

    public function set_orientation($data)
    {
        $this->orientation = $data;
    }

    public function set_locale($data)
    {
        $this->locale = $data;
    }

    public function set_plugins($data)
    {
        $this->plugins = $data;
    }

    public function set_mimetypes($data)
    {
        $this->mimetypes = $data;
    }

    public function set_nav_connection($data)
    {
        $this->nav_connection = $data;
    }

    public function set_duration($data)
    {
        $this->duration = $data;
    }


    public function serialize_object($type=SERIALIZE_DATABASE)
    {
        $data = Array(
            'device_id'                 => $this->id,
            'user_id'                   => $this->user_id,
            'device_identifier'         => $this->identifier,
            'device_identifier_type'    => $this->identifier_type,
            'device_mac_address'        => $this->mac_address,
            'device_user_agent'         => $this->user_agent,
            'device_heuristic'          => $this->heuristic,
            'device_ontouchstart'       => $this->ontouchstart,
            'device_pixel_ratio'        => $this->pixel_ratio,
            'device_color_depth'        => $this->color_depth,
            'device_screen_width'       => $this->screen_width,
            'device_screen_height'      => $this->screen_height,
            'device_browser'            => $this->browser,
            'device_os'                 => $this->os,
            'device_history_length'     => $this->history_length,
            'device_view_count'         => $this->view_count,
            'device_timestamp'          => $this->timestamp,
            'device_audio_context'      => $this->audio_context,
            'device_qc'                 => $this->qc,
            'device_tcreate'            => $this->date_created,
            'device_tmodified'          => $this->date_modified,


            'device_ss_qc'              => $this->ss_qc,
            'device_platform'           => $this->platform,
            'device_timezone'           => $this->timezone,
            'device_character_set'      => $this->character_set,
            'device_os_version'         => $this->os_version,
            'device_browser_version'    => $this->browser_version,
            'device_is_bot'             => $this->is_bot,

            'device_hardware_concurrency'   =>$this->hardware_concurrency,
            'device_maxtouchpoints'         =>$this->maxtouchpoints,
            'device_createtouch'            =>$this->createtouch,
            'device_onorientationchange'    =>$this->onorientationchange,
            'device_orientation'            =>$this->orientation,
            'device_locale'                 =>$this->locale,
            'device_plugins'                =>$this->plugins,
            'device_mimetypes'              =>$this->mimetypes,
            'device_nav_connection'         =>$this->nav_connection,
            'device_duration'               =>$this->duration,

            'device_dnt'=>                    $this->dnt,
            'device_adblock'=>                $this->adblock,
            'device_cookies_enabled'=>        $this->cookies_enabled,
            'device_fonts'=>                  $this->fonts,
            'device_indexed_db'=>             $this->indexed_db,
            'device_local_storage'=>          $this->local_storage,
            'device_open_db'=>                $this->open_db,
            'device_session_storage'=>        $this->session_storage,
            'device_webgl'=>                  $this->webgl,
            'device_flag_browser'=>           $this->flag_browser,
            'device_flag_language'=>          $this->flag_language,
            'device_flag_os'=>                $this->flag_os,
            'device_flag_resolution'=>        $this->flag_resolution,

            'device_session_twitter'        => $this->session_twitter,
            'device_session_reddit'         => $this->session_reddit,
            'device_session_facebook'       => $this->session_facebook,
            'device_session_google'         => $this->session_google,
            'device_session_amazon'         => $this->session_amazon,
            'device_session_googleplus'     => $this->session_googleplus,
            'device_gyro_alpha'             => $this->gyro_alpha,
            'device_gyro_qc'                => $this->gyro_qc,
            'device_gyro_beta'              => $this->gyro_beta,
            'device_gyro_gamma'             => $this->gyro_gamma,
            'device_dev_tool'               => $this->dev_tool



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



    public function __construct($device = null)
    {
        /** ===================
         *  LOAD FROM OBJECT ID
         *  ===================
         *  If an device ID is provided, lets fetch the data for this particular object
         */
        if($device != null && is_numeric($device))
        {
            $device_id = $device;
            $db_conditions = Array();
            $db_conditions['device_id'] = $device_id;

            $db_columns = array(
                'device_id',
                'user_id',
                'device_identifier',
                'device_identifier_type',
                'device_mac_address',
                'device_user_agent',
                'device_heuristic',
                'device_ontouchstart',
                'device_pixel_ratio',
                'device_color_depth',
                'device_screen_width',
                'device_screen_height',
                'device_browser',
                'device_os',
                'device_history_length',
                'device_view_count',
                'device_qc',
                'device_timestamp',
                'device_audio_context',

                'device_hardware_concurrency',
                'device_maxtouchpoints',
                'device_createtouch',
                'device_onorientationchange',
                'device_orientation',
                'device_locale',
                'device_plugins',
                'device_mimetypes',
                'device_nav_connection',
                'device_duration',

                'device_ss_qc',
                'device_platform'  ,
                'device_timezone',
                'device_character_set',
                'device_os_version',
                'device_browser_version',
                'device_is_bot',

                'device_dnt',
                'device_adblock',
                'device_cookies_enabled',
                'device_fonts',
                'device_indexed_db',
                'device_local_storage',
                'device_open_db',
                'device_session_storage',
                'device_webgl',
                'device_flag_browser',
                'device_flag_language',
                'device_flag_os',
                'device_flag_resolution',

                'device_session_twitter',
                'device_session_reddit',
                'device_session_facebook',
                'device_session_google',
                'device_session_amazon',
                'device_session_googleplus',
                'device_gyro_alpha',
                'device_gyro_beta',
                'device_gyro_gamma',
                'device_dev_tool'

            );
            $result = $this->db_retrieve(self::TABLE_DEVICE,$db_columns,$db_conditions,null,false);
            if(empty($result[0]))
                throw new Exception('device ID ' . $device_id . ' is not a valid device_id.');

            $this->set_id($device_id);
            $this->set_user_id($result[0]['user_id']);
            $this->set_identifier($result[0]['device_identifier']);
            $this->set_identifier_type($result[0]['device_identifier_type']);
            $this->set_mac_address($result[0]['device_mac_address']);
            $this->set_user_agent($result[0]['device_user_agent']);
            $this->set_heuristic($result[0]['device_heuristic']);
            $this->set_ontouchstart($result[0]['device_ontouchstart']);
            $this->set_pixel_ratio($result[0]['device_pixel_ratio']);
            $this->set_color_depth($result[0]['device_depth']);
            $this->set_screen_width($result[0]['device_screen_width']);
            $this->set_screen_height($result[0]['device_screen_height']);
            $this->set_browser($result[0]['device_browser']);
            $this->set_os($result[0]['device_os']);
            $this->set_history_length($result[0]['device_history_length']);
            $this->set_view_count($result[0]['device_view_count']);
            $this->set_timestamp($result[0]['device_timestamp']);
            $this->set_audio_context($result[0]['device_audio_context']);
            $this->set_qc($result[0]['device_qc']);

            $this->set_hardware_concurrency($result[0]['device_hardware_concurrency']);
            $this->set_maxtouchpoints($result[0]['device_maxtouchpoints']);
            $this->set_createtouch($result[0]['device_createtouch']);
            $this->set_onorientationchange($result[0]['device_onorientationchange']);
            $this->set_orientation($result[0]['device_orientation']);
            $this->set_locale($result[0]['device_locale']);
            $this->set_plugins($result[0]['device_plugins']);
            $this->set_mimetypes($result[0]['device_mimetypes']);
            $this->set_nav_connection($result[0]['device_nav_connection']);
            $this->set_duration($result[0]['device_duration']);

            $this->set_ss_qc($result[0]['device_ss_qc']);
            $this->set_platform($result[0]['device_platform']);
            $this->set_timezone($result[0]['device_timezone']);
            $this->set_character_set($result[0]['device_character_set']);
            $this->set_os_version($result[0]['device_os_version']);
            $this->set_browser_version($result[0]['device_browser_version']);
            $this->set_is_bot($result[0]['device_is_bot']);


            $this->set_dnt($result[0]['device_dnt']);
            $this->set_adblock($result[0]['device_adblock']);
            $this->set_cookies_enabled($result[0]['device_cookies_enabled']);
            $this->set_fonts($result[0]['device_fonts']);
            $this->set_indexed_db($result[0]['device_indexed_db']);
            $this->set_local_storage($result[0]['device_local_storage']);
            $this->set_open_db($result[0]['device_open_db']);
            $this->set_session_storage($result[0]['device_session_storage']);
            $this->set_webgl($result[0]['device_webgl']);
            $this->set_flag_browser($result[0]['device_flag_browser']);
            $this->set_flag_language($result[0]['device_flag_language']);
            $this->set_flag_os($result[0]['device_flag_os']);
            $this->set_flag_resolution($result[0]['device_flag_resolution']);



            $this->set_session_twitter($result[0]['device_session_twitter']);
            $this->set_session_reddit($result[0]['device_session_reddit']);
            $this->set_session_facebook($result[0]['device_session_facebook']);
            $this->set_session_google($result[0]['device_session_google']);
            $this->set_session_amazon($result[0]['device_session_amazon']);
            $this->set_session_googleplus($result[0]['device_session_googleplus']);

            $this->set_gyro_alpha($result[0]['device_gyro_alpha']);
            $this->set_gyro_beta($result[0]['device_gyro_beta']);
            $this->set_gyro_gamma($result[0]['device_gyro_gamma']);


            $this->set_date_created($result[0]['device_tcreate']);
            $this->set_date_modified($result[0]['device_tmodified']);

        } elseif(is_array($device))
        {
            /** =============================
             *  NEW OBJECT FROM ARRAY OF DATA
             *  =============================
             *  If an array off data is being loaded, then lets go ahead and load them into the object
             */

            foreach($device as $key=>$val)
            {
                if($key == 'device_id')              $this->set_id($val);
                if($key == 'user_id')                $this->set_user_id($val);

                if($key == 'device_identifier')      $this->set_identifier($val);
                if($key == 'device_identifier_type') $this->set_identifier_type($val);
                if($key == 'device_mac_address')     $this->set_mac_address($val);
                if($key == 'device_user_agent')      $this->set_user_agent($val);
                if($key == 'device_heuristic')       $this->set_heuristic($val);
                if($key == 'device_ontouchstart')    $this->set_ontouchstart($val);
                if($key == 'device_pixel_ratio')     $this->set_pixel_ratio($val);
                if($key == 'device_color_depth')     $this->set_color_depth($val);
                if($key == 'device_screen_width')    $this->set_screen_width($val);
                if($key == 'device_screen_height')   $this->set_screen_height($val);
                if($key == 'device_browser')         $this->set_browser($val);
                if($key == 'device_os')              $this->set_os($val);
                if($key == 'device_history_length')  $this->set_history_length($val);
                if($key == 'device_view_count')      $this->set_view_count($val);
                if($key == 'device_timestamp')       $this->set_timestamp($val);
                if($key == 'device_qc')              $this->set_qc($val);
                if($key == 'device_audio_context')   $this->set_audio_context($val);

                if($key == 'device_hardware_concurrency')                           $this->set_hardware_concurrency($val);
                if($key == 'device_maxtouchpoints')                                 $this->set_maxtouchpoints($val);
                if($key == 'device_createtouch')                                    $this->set_createtouch($val);
                if($key == 'device_onorientationchange')                            $this->set_onorientationchange($val);
                if($key == 'device_orientation')                                    $this->set_orientation($val);
                if($key == 'device_locale')                                         $this->set_locale($val);
                if($key == 'device_plugins')                                        $this->set_plugins($val);
                if($key == 'device_mimetypes')                                      $this->set_mimetypes($val);
                if($key == 'device_nav_connection')                                 $this->set_nav_connection($val);
                if($key == 'device_duration')                                        $this->set_duration($val);



                if($key == 'device_ss_qc')              $this->set_ss_qc($val);
                if($key == 'device_platform')           $this->set_platform($val);
                if($key == 'device_timezone')           $this->set_timezone($val);
                if($key == 'device_character_set')      $this->set_character_set($val);
                if($key == 'device_os_version')         $this->set_os_version($val);
                if($key == 'device_browser_version')    $this->set_browser_version($val);
                if($key == 'device_is_bot')             $this->set_is_bot($val);


                if($key == 'device_dnt')                $this->set_dnt($val);
                if($key == 'device_adblock')            $this->set_adblock($val);
                if($key == 'device_cookies_enabled')    $this->set_cookies_enabled($val);
                if($key == 'device_fonts')              $this->set_fonts($val);
                if($key == 'device_indexed_db')         $this->set_indexed_db($val);
                if($key == 'device_local_storage')      $this->set_local_storage($val);
                if($key == 'device_open_db')            $this->set_open_db($val);
                if($key == 'device_session_storage')    $this->set_session_storage($val);
                if($key == 'device_webgl')              $this->set_webgl($val);
                if($key == 'device_flag_browser')       $this->set_flag_browser($val);
                if($key == 'device_flag_language')      $this->set_flag_language($val);
                if($key == 'device_flag_os')            $this->set_flag_os($val);
                if($key == 'device_flag_resolution')    $this->set_flag_resolution($val);


                if($key == 'device_session_twitter')        $this->set_session_twitter($val);
                if($key == 'device_session_reddit')         $this->set_session_reddit($val);
                if($key == 'device_session_facebook')       $this->set_session_facebook($val);
                if($key == 'device_session_google')         $this->set_session_google($val);
                if($key == 'device_session_amazon')         $this->set_session_amazon($val);
                if($key == 'device_session_googleplus')     $this->set_session_googleplus($val);
                if($key == 'device_gyro_alpha')             $this->set_gyro_alpha ($val);
                if($key == 'device_gyro_beta')              $this->set_gyro_beta($val);
                if($key == 'device_gyro_gamma')             $this->set_gyro_gamma($val);
                if($key == 'device_dev_tool')               $this->set_dev_tool($val);


                if($key == 'device_tcreate')         $this->set_date_created($val);
                if($key == 'device_tmodified')       $this->set_date_modified ($val);
            }
        }
    }



    public function update_device($device = null)
    {
        $device_id = null;
        $db_columns = Array();

        if($device == null && !is_numeric($this->id))
            throw new Exception('You must provide a device_id or set a device ID to this device object.');
        if(!is_array($device) && $device == null) $device = $this->id;

        /**
         *  This method can either take an array of valid device table columns
         *  and store it, if it is not provided, it will assume to save all
         *  the properties within the object
         */

        if($device != null && is_array($device))
        {
            if(($this->id == null || !isset($this->id) || !is_numeric($this->id)) && isset($device['device_id']) && is_numeric($device['device_id']))
            $device_id = $device['device_id'];
            else
                $device_id = $this->id;
            $data = $device;
            foreach($data as $key=>$val)
            {
                if($key == 'user_id')                   $db_columns[$key] = $val;
                if($key == 'device_identifier')         $db_columns[$key] = $val;
                if($key == 'device_identifier_type')    $db_columns[$key] = $val;
                if($key == 'device_mac_address')        $db_columns[$key] = $val;
                if($key == 'device_user_agent')         $db_columns[$key] = $val;
                if($key == 'device_heuristic')          $db_columns[$key] = $val;
                if($key == 'device_ontouchstart')       $db_columns[$key] = $val;
                if($key == 'device_pixel_ratio')        $db_columns[$key] = $val;
                if($key == 'device_color_depth')        $db_columns[$key] = $val;
                if($key == 'device_screen_width')       $db_columns[$key] = $val;
                if($key == 'device_screen_height')      $db_columns[$key] = $val;
                if($key == 'device_browser')            $db_columns[$key] = $val;
                if($key == 'device_os')                 $db_columns[$key] = $val;
                if($key == 'device_history_length')     $db_columns[$key] = $val;
                if($key == 'device_view_count')         $db_columns[$key] = $val;
                if($key == 'device_timestamp')          $db_columns[$key] = $val;
                if($key == 'device_qc')                 $db_columns[$key] = $val;
                if($key == 'device_audio_context')      $db_columns[$key] = $val;
                /*****************************************************************/
                if($key == 'device_hardware_concurrency') $db_columns[$key] = $val;
                if($key == 'device_maxtouchpoints')       $db_columns[$key] = $val;
                if($key == 'device_createtouch')          $db_columns[$key] = $val;
                if($key == 'device_onorientationchange')  $db_columns[$key] = $val;
                if($key == 'device_orientation')          $db_columns[$key] = $val;
                if($key == 'device_locale')               $db_columns[$key] = $val;
                if($key == 'device_plugins')              $db_columns[$key] = $val;
                if($key == 'device_mimetypes')            $db_columns[$key] = $val;
                if($key == 'device_nav_connection')       $db_columns[$key] = $val;
                if($key == 'device_duration')             $db_columns[$key] = $val;

                /*****************************************************************/

                if($key == 'device_ss_qc')              $db_columns[$key] = $val;
                if($key == 'device_platform')           $db_columns[$key] = $val;
                if($key == 'device_timezone')           $db_columns[$key] = $val;
                if($key == 'device_character_set')      $db_columns[$key] = $val;
                if($key == 'device_os_version')         $db_columns[$key] = $val;
                if($key == 'device_browser_version')    $db_columns[$key] = $val;
                if($key == 'device_is_bot')             $db_columns[$key] = $val;

                if($key == 'device_dnt')                $db_columns[$key] = $val;
                if($key == 'device_adblock')            $db_columns[$key] = $val;
                if($key == 'device_cookies_enabled')    $db_columns[$key] = $val;
                if($key == 'device_fonts')              $db_columns[$key] = $val;
                if($key == 'device_indexed_db')         $db_columns[$key] = $val;
                if($key == 'device_local_storage')      $db_columns[$key] = $val;
                if($key == 'device_open_db')            $db_columns[$key] = $val;
                if($key == 'device_session_storage')    $db_columns[$key] = $val;
                if($key == 'device_webgl')              $db_columns[$key] = $val;
                if($key == 'device_flag_browser')       $db_columns[$key] = $val;
                if($key == 'device_flag_language')      $db_columns[$key] = $val;
                if($key == 'device_flag_os')            $db_columns[$key] = $val;
                if($key == 'device_flag_resolution')    $db_columns[$key] = $val;

                /*****************************************************************/

                if($key == 'device_session_twitter')        $db_columns[$key] = $val;
                if($key == 'device_session_reddit')         $db_columns[$key] = $val;
                if($key == 'device_session_facebook')       $db_columns[$key] = $val;
                if($key == 'device_session_google')         $db_columns[$key] = $val;
                if($key == 'device_session_amazon')         $db_columns[$key] = $val;
                if($key == 'device_session_googleplus')     $db_columns[$key] = $val;
                if($key == 'device_gyro_alpha')             $db_columns[$key] = $val;
                if($key == 'device_gyro_beta')              $db_columns[$key] = $val;
                if($key == 'device_gyro_gamma')             $db_columns[$key] = $val;
                if($key == 'device_dev_tool')               $db_columns[$key] = $val;





            }

        } elseif($device != null && is_numeric($device))
        {
            $device_id = $device;
            $this->id = $device_id;
            /**
             *  No array data provided, then lets just save the properties within the object
             */

            if($this->id                 != null) $db_columns['device_id']              = $this->id;
            if($this->user_id            != null) $db_columns['user_id']                = $this->user_id;
            if($this->identifier         != null) $db_columns['device_identifier']      = $this->identifier;
            if($this->identifier_type    != null) $db_columns['device_identifier_type'] = $this->identifier_type;
            if($this->mac_address        != null) $db_columns['device_mac_address']     = $this->mac_address;
            if($this->user_agent         != null) $db_columns['device_user_agent']      = $this->user_agent;
            if($this->heuristic          != null) $db_columns['device_heuristic']       = $this->heuristic;
            if($this->ontouchstart       != null) $db_columns['device_ontouchstart']    = $this->ontouchstart;
            if($this->pixel_ratio        != null) $db_columns['device_pixel_ratio']     = $this->pixel_ratio;
            if($this->color_depth        != null) $db_columns['device_color_depth']     = $this->color_depth;
            if($this->screen_width       != null) $db_columns['device_screen_width']    = $this->screen_width;
            if($this->screen_height      != null) $db_columns['device_screen_height']   = $this->screen_height;
            if($this->browser            != null) $db_columns['device_browser']         = $this->browser;
            if($this->os                 != null) $db_columns['device_os']              = $this->os;
            if($this->history_length     != null) $db_columns['device_history_length']  = $this->history_length;
            if($this->view_count         != null) $db_columns['device_view_count']      = $this->view_count;
            if($this->qc                 != null) $db_columns['device_qc']              = $this->qc;
            if($this->timestamp          != null) $db_columns['device_timestamp']       = $this->timestamp;
            if($this->audio_context      != null) $db_columns['device_audio_context']   = $this->audio_context;

            if($this->hardware_concurrency != null) $db_columns['device_hardware_concurrency'] = $this->hardware_concurrency;
            if($this->maxtouchpoints != null)        $db_columns['device_maxtouchpoints']       = $this->maxtouchpoints;
            if($this->createtouch != null)           $db_columns['device_createtouch']          = $this->createtouch;
            if($this->onorientationchange != null)   $db_columns['device_onorientationchange']  = $this->onorientationchange;
            if($this->orientation != null)           $db_columns['device_orientation']          = $this->orientation;
            if($this->locale != null)                $db_columns['device_locale']               = $this->locale;
            if($this->plugins != null)               $db_columns['device_plugins']              = $this->plugins;
            if($this->mimetypes != null)             $db_columns['device_mimetypes']            = $this->mimetypes;
            if($this->nav_connection != null)        $db_columns['device_nav_connection']       = $this->nav_connection;
            if($this->duration != null)             $db_columns['device_duration']             = $this->duration;


            if($this->ss_qc !=null)             $db_columns['device_ss_qc'] = $this->ss_qc;
            if($this->platform !=null)          $db_columns['device_platform'] = $this->platform;
            if($this->timezone !=null)          $db_columns['device_timezone'] = $this->timezone;
            if($this->character_set !=null)     $db_columns['device_character_set'] = $this->character_set;
            if($this->os_version !=null)        $db_columns['device_os_version'] = $this->os_version;
            if($this->browser_version !=null)   $db_columns['device_browser_version'] = $this->browser_version;
            if($this->is_bot !=null)            $db_columns['device_is_bot'] = $this->is_bot;


            if($this->dnt !=null)                $db_columns['device_dnt'] =                   $this->dnt;
            if($this->adblock !=null)            $db_columns['device_adblock'] =               $this->adblock;
            if($this->cookies_enabled !=null)    $db_columns['device_cookies_enabled'] =       $this->cookies_enabled;
            if($this->fonts !=null)              $db_columns['device_fonts'] =                 $this->fonts;
            if($this->indexed_db !=null)         $db_columns['device_indexed_db'] =            $this->indexed_db;
            if($this->local_storage !=null)      $db_columns['device_local_storage'] =         $this->local_storage;
            if($this->open_db !=null)            $db_columns['device_open_db'] =               $this->open_db;
            if($this->session_storage !=null)    $db_columns['device_session_storage'] =       $this->session_storage;
            if($this->webgl !=null)              $db_columns['device_webgl'] =                 $this->webgl;
            if($this->flag_browser !=null)       $db_columns['device_flag_browser'] =          $this->flag_browser;
            if($this->flag_language !=null)      $db_columns['device_flag_language'] =         $this->flag_language;
            if($this->flag_os !=null)            $db_columns['device_flag_os'] =               $this->flag_os;
            if($this->flag_resolution !=null)    $db_columns['device_flag_resolution'] =       $this->flag_resolution;

            if($this->session_twitter !=null)    $db_columns['device_session_twitter'] =       $this->session_twitter;
            if($this->session_reddit !=null)     $db_columns['device_session_reddit'] =        $this->session_reddit;
            if($this->session_facebook !=null)   $db_columns['device_session_facebook'] =      $this->session_facebook;
            if($this->session_google !=null)     $db_columns['device_session_google'] =        $this->session_google;
            if($this->session_amazon !=null)     $db_columns['device_session_amazon'] =        $this->session_amazon;
            if($this->session_googleplus !=null) $db_columns['device_session_googleplus'] =    $this->session_googleplus;
            if($this->gyro_alpha !=null)         $db_columns['device_gyro_alpha'] =            $this->gyro_alpha;
            if($this->gyro_beta !=null)          $db_columns['device_gyro_beta'] =             $this->gyro_beta;
            if($this->gyro_gamma !=null)         $db_columns['device_gyro_gamma'] =            $this->gyro_gamma;
            if($this->dev_tool !=null)           $db_columns['device_dev_tool'] =              $this->dev_tool;

            $db_columns['device_tmodified'] = current_timestamp();
        }

        if(empty($db_columns))
            throw new Exception('No data provided to update device');

        $db_conditions = array('device_id'=>$device_id);

        try {
            $this->db_update(self::TABLE_DEVICE,$db_columns,$db_conditions,false);
        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
    }


    public function add_device($device = null)
    {
        /**
         *  $device should be a device object being passed
         */

        if($device instanceof DeviceModel)
        {
            $db_columns =  $device->serialize_object();
            if(!isset($db_columns['device_id'])) $db_columns['device_id'] = $this->id;

        } else {
            throw new Exception('Not a valid device object!' . print_r($device,true));
        }

        if(isset($db_columns['device_id'])) unset($db_columns['device_id']);
        $db_columns['device_tcreate'] = current_timestamp();
        $db_columns['device_tmodified'] = current_timestamp();

        try {
            $insert_id = $this->db_create(self::TABLE_DEVICE,$db_columns);
            return $insert_id;

        } catch(Exception $e) {
            error_log('Error'. $e->getCode() .': '. $e->getMessage());
        }
        return false;
    }



    public static function get_device_by_user_id($user_id=null)
    {
        /**
         *  RETURNS OBJECT
         */
        if($user_id == null)
            throw new Exception('User identifier provided must be a user_id');

        $db_conditions = Array('user_id'=>$user_id);

        $db_columns = array(
            'device_id',
            'user_id',
            'device_identifier',
            'device_identifier_type',
            'device_mac_address',
            'device_user_agent',
            'device_heuristic',
            'device_ontouchstart',
            'device_pixel_ratio',
            'device_color_depth',
            'device_screen_width',
            'device_screen_height',
            'device_browser',
            'device_os',
            'device_history_length',
            'device_view_count',
            'device_timestamp',
            'device_audio_context',
            'device_qc',
            'device_hardware_concurrency',
            'device_maxtouchpoints',
            'device_createtouch',
            'device_onorientationchange',
            'device_orientation',
            'device_locale',
            'device_plugins',
            'device_mimetypes',
            'device_nav_connection',
            'device_duration',

            'device_ss_qc',
            'device_platform'  ,
            'device_timezone',
            'device_character_set',
            'device_os_version',
            'device_browser_version',
            'device_is_bot' ,

            'device_dnt',
            'device_adblock',
            'device_cookies_enabled',
            'device_fonts',
            'device_indexed_db',
            'device_local_storage',
            'device_open_db',
            'device_session_storage' ,
            'device_webgl',
            'device_flag_browser',
            'device_flag_language',
            'device_flag_os',
            'device_flag_resolution',

            'device_session_twitter',
            'device_session_reddit',
            'device_session_facebook',
            'device_session_google',
            'device_session_amazon',
            'device_session_googleplus',
            'device_gyro_qc',
            'device_gyro_alpha',
            'device_gyro_beta',
            'device_gyro_gamma',
            'device_dev_tool',
            'ip_campaign_click_id'


        );

        $db_instance = new Database();

        $result = $db_instance->db_retrieve(self::TABLE_DEVICE,$db_columns,$db_conditions,null,false);
        unset($db_instance);
        if(empty($result[0]))
            return false;
        else return new DeviceModel($result[0]);

    }

}




