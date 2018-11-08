<?php
/** =================
 *  tracker.class.php
 *  =================
 *  trackers the user
 */
class Tracker
{

    /** +------------------------+
     *  | DEVICE JAVASCRIPT DATA |
     *  +------------------------+*/
    public $user_fingerprint ='';
    public $device_identifier;
    public $device_identifier_type;
    public $device_mac_address;
    public $device_heuristic;
    public $device_ontouchstart;
    public $device_pixel_ratio;
    public $device_color_depth;
    public $device_screen_width;
    public $device_screen_height;
    public $device_history_length;
    public $device_qc;
    public $device_audio_context;
    public $device_timestamp;
    public $device_hardware_concurrency;
    public $device_maxtouchpoints;
    public $device_createtouch;
    public $device_onorientationchange;
    public $device_orientation;
    public $device_locale;
    public $device_plugins;
    public $device_mimetypes;
    public $device_nav_connection;
    public $device_duration;

    public $device_dnt;
    public $device_adblock;
    public $device_cookies_enabled;
    public $device_fonts;
    public $device_indexed_db;
    public $device_local_storage;
    public $device_open_db;
    public $device_session_storage;
    public $device_webgl;
    public $device_flag_browser;
    public $device_flag_language;
    public $device_flag_os;
    public $device_flag_resolution;

    public $device_session_twitter;
    public $device_session_reddit;
    public $device_session_facebook;
    public $device_session_google;
    public $device_session_amazon;
    public $device_session_googleplus;
    public $device_gyro_alpha;
    public $device_gyro_qc;
    public $device_gyro_beta;
    public $device_gyro_gamma;
    public $device_dev_tool;
    public $ip_campaign_click_id;




        //just added

    /** +-----------------+
     *  | DEVICE PHP DATA |
     *  +-----------------+*/
    public $device_user_agent = null;
    //public $device_cookie = null;
    public $device_os = null;
    public $device_os_version = null;
    public $device_browser = null;
    public $device_browser_version = null;
    public $device_ss_locale = null;
    public $device_platform = null;
    public $device_is_mobile = null;
    public $device_is_bot = null;
    public $device_timezone = null;
    public $device_character_set = null;


    /** +---------------------+
     *  | TRAFFIC INFORMATION |
     *  +---------------------+*/
    public $ip_address;
    public $ip_referrer;
    public $ip_url;
    public $ip_hostname;
    public $ip_request_method;
    public $ip_accept_header;
    public $ip_campaign_id;
    public $ip_zone_id;
    public $ip_note = null;
    public $ip_is_mraid;


    /** +------------------------+
     *  | GEOGRAPHIC INFORMATION |
     *  +------------------------+*/
    public $ip_country;
    public $ip_city;
    public $ip_location;
    public $ip_postal_code;
    public $ip_metro_code;

    /** +----------------------+
     *  | PROVIDER INFORMATION |
     *  +----------------------+*/
    public $ip_connection;
    public $ip_domain;
    public $ip_organization;
    public $ip_provider;
    public $ip_asn_name = null;
    public $ip_asn = null;
    public $ip_is_monitor = null;
    public $ip_timezone;





    public function __construct($data = null)
    {
        if(is_array($data) && isset($data['ip_address']))
        {

            foreach($data as $key=>$val)
            {
                if($key == 'device_user_agent')             $this->device_user_agent = $val;
                //if($key == 'device_cookie')                 $this->device_cookie = $val;
                //if($key == 'device_os')                     $this->device_os = $val;
                if($key == 'device_os_version')             $this->device_os_version = $val;
                if($key == 'device_browser')                $this->device_browser = $val;
                if($key == 'device_browser_version')        $this->device_browser_version = $val;
                if($key == 'device_ss_locale')              $this->device_ss_locale = $val;
                if($key == 'device_platform')               $this->device_platform = $val;
                if($key == 'device_is_mobile')              $this->device_is_mobile = $val;
                if($key == 'device_is_bot')                 $this->device_is_bot = $val;




                if($key == 'user_fingerprint')              $this->user_fingerprint = $val;
                if($key == 'device_identifier')             $this->device_identifier = $val;
                //if($key == 'device_identifier_type')        $this->device_identifier_type = $val;
                if($key == 'device_mac_address')            $this->device_mac_address = $val;
                if($key == 'device_user_agent')             $this->device_user_agent = $val;
                if($key == 'device_heuristic')              $this->device_heuristic = $val;
                if($key == 'device_ontouchstart')           $this->device_ontouchstart = $val;
                if($key == 'device_pixel_ratio')            $this->device_pixel_ratio = $val;
                if($key == 'device_color_depth')            $this->device_color_depth = $val;
                if($key == 'device_screen_width')           $this->device_screen_width = $val;
                if($key == 'device_screen_height')          $this->device_screen_height = $val;
                if($key == 'device_browser')                $this->device_browser = $val;
                if($key == 'device_os')                     $this->device_os = $val;
                if($key == 'device_history_length')         $this->device_history_length = $val;
                if($key == 'device_qc')                     $this->device_qc = $val;
                if($key == 'device_audio_context')          $this->device_audio_context = $val;
                if($key == 'device_timestamp')              $this->device_timestamp = $val;

                if($key == 'device_hardware_concurrency')   $this->device_hardware_concurrency = $val;
                if($key == 'device_maxtouchpoints')         $this->device_maxtouchpoints = $val;
                if($key == 'device_createtouch')            $this->device_createtouch = $val;
                if($key == 'device_onorientationchange')    $this->device_onorientationchange = $val;
                if($key == 'device_orientation')            $this->device_orientation = $val;
                if($key == 'device_locale')                 $this->device_locale = $val;
                if($key == 'device_plugins')                $this->device_plugins = $val;
                if($key == 'device_mimetypes')              $this->device_mimetypes = $val;
                if($key == 'device_nav_connection')         $this->device_nav_connection = $val;
                if($key == 'device_duration')               $this->device_duration = $val;

                if($key == 'device_timezone')               $this->device_timezone = $val;
                if($key == 'device_character_set')          $this->device_character_set = $val;

                if($key == 'ip_referrer')                   $this->ip_referrer = $val;
                if($key == 'ip_url')                        $this->ip_url = $val;
                if($key == 'ip_campaign_id')                $this->ip_campaign_id = $val;
                if($key == 'ip_zone_id')                    $this->ip_zone_id = $val;
                if($key == 'ip_hostname')                   $this->ip_hostname = $val;
                if($key == 'ip_is_mraid')                   $this->ip_is_mraid = $val;
                if($key == 'ip_asn_name')                   $this->ip_asn_name = $val;
                if($key == 'ip_asn')                        $this->ip_asn = $val;
                if($key == 'ip_is_monitor')                 $this->ip_is_monitor = $val;
                if($key == 'ip_connection')                 $this->ip_connection = $val;
                if($key == 'ip_address')                    $this->ip_address = $val;
                if($key == 'ip_accept_header')              $this->ip_accept_header = $val;
                if($key == 'ip_note')                       $this->ip_note = $val;
                if($key == 'ip_timezone')                       $this->ip_timezone = $val;



                if($key == 'ip_country') $this->ip_country = $val;
                if($key == 'ip_domain') $this->ip_domain = $val;
                if($key == 'ip_city') $this->ip_city =$val;
                if($key == 'ip_location') $this->ip_location = $val;
                if($key == 'ip_postal_code') $this->ip_postal_code = $val;
                if($key == 'ip_metro_code') $this->ip_metro_code =$val;
                if($key == 'ip_organization') $this->ip_organization = $val;
                if($key == 'ip_provider') $this->ip_provider =$val;



                if($key == 'device_dnt')                    $this->device_dnt = $val;
                if($key == 'device_adblock')                $this->device_adblock = $val;
                if($key == 'device_cookies_enabled')        $this->device_cookies_enabled = $val;
                if($key == 'device_fonts')                  $this->device_fonts = $val;
                if($key == 'device_indexed_db')             $this->device_indexed_db = $val;
                if($key == 'device_local_storage')          $this->device_local_storage = $val;
                if($key == 'device_open_db')                $this->device_open_db = $val;
                if($key == 'device_session_storage')        $this->device_session_storage = $val;
                if($key == 'device_webgl')                  $this->device_webgl = $val;
                if($key == 'device_flag_browser')           $this->device_flag_browser = $val;
                if($key == 'device_flag_language')          $this->device_flag_language = $val;
                if($key == 'device_flag_os')                $this->device_flag_os = $val;
                if($key == 'device_flag_resolution')        $this->device_flag_resolution = $val;

                if($key == 'device_session_twitter')        $this->device_session_twitter = $val;
                if($key == 'device_session_reddit')         $this->device_session_reddit = $val;
                if($key == 'device_session_facebook')       $this->device_session_facebook = $val;
                if($key == 'device_session_google')         $this->device_session_google = $val;
                if($key == 'device_session_amazon')         $this->device_session_amazon = $val;
                if($key == 'device_session_googleplus')     $this->device_session_googleplus = $val;
                if($key == 'device_gyro_qc')                $this->device_gyro_qc = $val;
                if($key == 'device_gyro_alpha')             $this->device_gyro_alpha  = $val;
                if($key == 'device_gyro_beta')              $this->device_gyro_beta = $val;
                if($key == 'device_gyro_gamma')             $this->device_gyro_gamma = $val;
                if($key == 'device_dev_tool')               $this->device_dev_tool = $val;
                if($key == 'ip_campaign_click_id')          $this->ip_campaign_click_id = $val;







            }

            /*
            $this->user_fingerprint = (isset($data['user_fingerprint']))?$data['user_fingerprint']:false;
            $this->ip_address = (isset($data['ip_address']))?$data['ip_address']:'';
            $this->device_identifier = (isset($data['device_identifier']))?$data['device_identifier']:'';
            $this->device_identifier_type = (isset($data['device_identifier_type']))?$data['device_identifier_type']:'';
            $this->device_mac_address = (isset($data['device_mac_address']))?$data['device_mac_address']:'';
            $this->device_user_agent = (isset($data['device_user_agent']))?$data['device_user_agent']:'';
            $this->device_heuristic = (isset($data['device_heuristic']))?$data['device_heuristic']:'';
            $this->device_ontouchstart = (isset($data['device_ontouchstart']))?$data['device_ontouchstart']:'';
            $this->device_pixel_ratio = (isset($data['device_pixel_ratio']))?$data['device_pixel_ratio']:'';
            $this->device_color_depth = (isset($data['device_color_depth']))?$data['device_color_depth']:'';
            $this->device_screen_width = (isset($data['device_screen_width']))?$data['device_screen_width']:'';
            $this->device_screen_height = (isset($data['device_screen_height']))?$data['device_screen_height']:'';
            $this->device_browser = (isset($data['device_browser']))?$data['device_browser']:'';
            $this->device_os = (isset($data['device_os']))?$data['device_os']:'';
            $this->device_history_length = (isset($data['device_history_length']))?$data['device_history_length']:'';
            */


            /** =============================
             *  NEW OBJECT FROM ARRAY OF DATA
             *  =============================
             *
             *  Logic
             *  -----
             *      1) Find user_id by fingerprint
             *          -Found, increment / tmodified user table
             *          -Not found OR fingerprint not set, add user
             *      2) Find device_id by user_id (with fingerprint set)
             *          -Found, update
             *          -Not found, add
             *      3) Find IP by user_id and IP
             *          -Found, exit
             *          -Not found, add IP
             *              If org not exist, add
             *
             */

            /** +--------------------------+
             *  | FIND USER BY FINGERPRINT |
             *  +--------------------------+ */

            if($this->user_fingerprint) //lets grab the user object by looking it up with the fingerprint
                $user_instance = User::get_user_by_fingerprint($this->user_fingerprint); //if it's found, lets set it to user_instance, if not it will just be false


            /** +----------------------------+
             *  | IF NOT, CREATE A NEW USER! |
             *  +----------------------------+ */
            if(!isset($user_instance) || !$user_instance) //if a fingerprint is not provided or we could not find it
            {    //if it's not found, lets add a new user
                $user_instance = new User(Array(
                    'user_status'=>1,
                    'user_is_enabled'=>1,
                    'user_view_count'=>0,
                    'user_fingerprint'=>(isset($data['user_fingerprint']))?$data['user_fingerprint']:'', //if we were given a fingerprint before, let's use it!
                    'user_tmodified'=>current_timestamp(),
                    'user_tcreate'=>current_timestamp()
                ));
                $user_instance->add_user($user_instance); //let's add it to the database!
            }



            /** +---------------------------+
             *  | INCREMENT USER VIEW COUNT |
             *  +---------------------------+ */
            //as_error('user_id: ' . $user_instance->id . ' view_count: ' . $user_instance->view_count);
            //so at this point we have a user_instance whether new or fetched
            $user_instance->increment_view_count();
            //$user_instance->set_view_count($user_instance->view_count++); //let's increment the view count
            $user_id = (isset($user_instance->id))?$user_instance->id:0; //if for some reason we failed to insert to DB, lets at least continue and just make user_id 0
            $user_instance->update_user($user_instance); //we updated the view count or potentially added a fingerprint, lets update in the DB

            /** +-----------------------+
             *  | CHECK IF DEVICE IS IN |
             *  +-----------------------+ */
            $device_update = Array(
                'device_identifier'=>$this->device_identifier,
                'device_identifier_type'=>$this->device_identifier_type,
                'device_mac_address'=>$this->device_mac_address,
                'device_user_agent'=>$this->device_user_agent,
                'device_heuristic'=>$this->device_heuristic,
                'device_ontouchstart'=>$this->device_ontouchstart,
                'device_pixel_ratio'=>$this->device_pixel_ratio,
                'device_color_depth'=>$this->device_color_depth,
                'device_screen_width'=>$this->device_screen_width,
                'device_screen_height'=>$this->device_screen_height,
                'device_browser'=>$this->device_browser,
                'device_os'=>$this->device_os,
                'device_history_length'=>$this->device_history_length,

                'device_hardware_concurrency'   =>$this->device_hardware_concurrency,
                'device_maxtouchpoints'         =>$this->device_maxtouchpoints,
                'device_createtouch'            =>$this->device_createtouch,
                'device_onorientationchange'    =>$this->device_onorientationchange,
                'device_orientation'            =>$this->device_orientation,
                'device_locale'                 =>$this->device_locale,
                'device_plugins'                =>$this->device_plugins,
                'device_mimetypes'              =>$this->device_mimetypes,
                'device_nav_connection'         =>$this->device_nav_connection,
                'device_duration'               =>$this->device_duration,
                'device_timestamp'              =>$this->device_timestamp,
                'device_audio_context'          =>$this->device_audio_context,
                'device_qc'                     =>$this->device_qc,
                'device_os_version'             =>$this->device_os_version,
                'device_browser_version'        =>$this->device_browser_version,
                'device_ss_local'               =>$this->device_ss_locale,
                'device_platform'               =>$this->device_platform,
                'device_is_mobile'              =>$this->device_is_mobile,
                'device_is_bot'                 =>$this->device_is_bot,
                'device_timezone'               =>$this->device_timezone,
                'device_character_set'          =>$this->device_character_set,


                'device_dnt'=>                    $this->device_dnt,
                'device_adblock'=>                $this->device_adblock,
                'device_cookies_enabled'=>        $this->device_cookies_enabled,
                'device_fonts'=>                  $this->device_fonts,
                'device_indexed_db'=>             $this->device_indexed_db,
                'device_local_storage'=>          $this->device_local_storage,
                'device_open_db'=>                $this->device_open_db,
                'device_session_storage'=>        $this->device_session_storage,
                'device_webgl'=>                  $this->device_webgl,
                'device_flag_browser'=>           $this->device_flag_browser,
                'device_flag_language'=>          $this->device_flag_language,
                'device_flag_os'=>                $this->device_flag_os,
                'device_flag_resolution'=>        $this->device_flag_resolution,

                'device_session_twitter'          =>$this->device_session_twitter,
                'device_session_reddit'           =>$this->device_session_reddit,
                'device_session_facebook'         =>$this->device_session_facebook,
                'device_session_google'           =>$this->device_session_google,
                'device_session_amazon'           =>$this->device_session_amazon,
                'device_session_googleplus'       =>$this->device_session_googleplus,

                'device_gyro_qc'                    =>$this->device_gyro_qc,
                'device_gyro_alpha'               =>$this->device_gyro_alpha,
                'device_gyro_beta'                =>$this->device_gyro_beta,
                'device_gyro_gamma'               =>$this->device_gyro_gamma,

                'device_dev_tool'                 =>$this->device_dev_tool,




            );


            /** +-----------------------+
             *  | CHECK IF DEVICE IS IN |
             *  +-----------------------+ */
            if($user_id)
                $device_instance = DeviceModel::get_device_by_user_id($user_id);

            if(!isset($device_instance) || !$device_instance)
            {
                $device_update['user_id'] = $user_id;
                $device_update['device_view_count'] = 1;
                $device_instance = new DeviceModel($device_update);
                $device_id = $device_instance->add_device($device_instance);
                //as_error('added new device: ' . $device_id);
            }

            if(!isset($device_id)) $device_id = $device_instance->id;
            $device_instance->increment_view_count();
            $device_update['device_view_count'] = $device_instance->view_count;


            /** +---------------------------+
             *  | UPDATE DEVICE INFORMATION |
             *  +---------------------------+ */

            //as_error('!!!!!! $device_update = ' . print_r($device_update,true));
            //$device_instance->set_view_count($device_instance->view_count++); //increment the view count for that device
            //$device_instance->set_id($device_id);
            $device_instance->update_device($device_update);



            /** +-----------------------------+
             *  | LETS ADD THE IP INFORMATION |
             *  +-----------------------------+ */

            //$this->get_ip_data();

            /** +------------------------------+
             *  | FIND IF GET ORG_ID IF EXISTS |
             *  +------------------------------+ */

            $org_array = Array(
                'org_name'=>$this->ip_organization,
                'org_domain'=>$this->ip_domain,
            );

            $org_id = OrgModel::get_org_id($org_array);
            if(!$org_id && strlen($this->ip_organization) > 1)
            {
                $org_instance = new OrgModel(Array(
                    'org_name'=>$this->ip_organization,
                    'org_domain'=>$this->ip_domain,
                    'org_type'=>0,
                    'org_status'=>1,
                    'org_tmodified'=>current_timestamp(),
                    'org_tcreate'=>current_timestamp(),

                ));
                $org_id = $org_instance->add_org($org_instance);
            }

            $ip_instance = new IpModel(Array(
                'user_id'=>$user_id,
                'org_id'=>$org_id,
                'device_id'=>$device_id,
                'ip_accept_header'=>$this->ip_accept_header,
                'ip_url'=>$this->ip_url,
                'ip_address'=>$this->ip_address,
                'ip_hostname'=>$this->ip_hostname,
                'ip_referrer'=>$this->ip_referrer,
                'ip_country'=>$this->ip_country,
                'ip_connection' =>$this->ip_connection,
                'ip_domain'=>$this->ip_domain,
                'ip_city'=>$this->ip_city ,
                'ip_note'=>$this->ip_note,
                'ip_location'=>$this->ip_location ,
                'ip_postal_code'=>$this->ip_postal_code,
                'ip_metro_code'=>$this->ip_metro_code,
                'ip_organization'=>$this->ip_organization,
                'ip_provider'=>$this->ip_provider,
                'ip_campaign_id'=>$this->ip_campaign_id,
                'ip_zone_id'=>$this->ip_zone_id,
                'ip_is_mraid' =>$this->ip_is_mraid,
                'ip_timezone'=>$this->ip_timezone,
                'ip_category'=>0,
                'ip_status'=>1,
                'ip_is_enabled'=>1,
                'ip_tmodified'=>current_timestamp(),
                'ip_tcreate'=>current_timestamp(),
                'ip_asn'=>$this->ip_asn, /**TODO: ADD BELOW!! **/
                'ip_asn_name'=>$this->ip_asn_name,
                'ip_is_monitor'=>$this->ip_is_monitor,
                'ip_campaign_click_id'            =>$this->ip_campaign_click_id,

            ));


            $ip_instance->add_ip($ip_instance);
            if($ip_instance) return true;
            else return false;


        } else {
               throw new Exception('Must provide an array of user tracking values');
       }
    }

}
