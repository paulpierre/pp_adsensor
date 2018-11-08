<?php
/** ==================
 *  identify.class.php
 *  ==================
 *  Audit's whether a user should or should not be allowed
 *
 *  DSP
 *
 *
 *  FACEBOOK
 *
 *
 *  GOOGLE
 *
 *
 *  BOT
 *
 *
 *
 *
 *
 */
use GeoIp2\Database\Reader;

class Identify extends Browser
{
    /**
     *  TODO: add a function either here or in the filter to do ip_is_monitor that checks against a blacklist
     */


/** +------------+
 *  | CLASS DATA |
 *  +------------+*/


/** +---------------------+
 *  | TRAFFIC INFORMATION |
 *  +---------------------+*/
    public $ip_address = null;
    public $ip_referrer = null;
    public $ip_url = null;
    public $ip_query_string = null;
    public $ip_hostname = null;
    public $ip_request_method = null;
    public $ip_accept_header = null;



/** +------------------------+
 *  | GEOGRAPHIC INFORMATION |
 *  +------------------------+*/
    public $ip_country = null;
    public $ip_city = null;
    public $ip_location = null;
    public $ip_postal_code = null;
    public $ip_timezone = null;

/** +----------------------+
 *  | PROVIDER INFORMATION |
 *  +----------------------+*/
    public $ip_domain = null;
    public $ip_organization = null;
    public $ip_provider = null; //ISP
    public $ip_asn_name = null;
    public $ip_asn = null;
    public $ip_connection = null;

    public $ip_is_monitor = null;



/** +--------------------+
 *  | DEVICE INFORMATION |
 *  +--------------------+*/
    public $device_user_agent = null;
    public $device_cookie = null;
    public $device_os = null;  //1:iOS 2:Android 3:OSX  4:Windows 5:Linux
    public $device_os_version = null;
    public $device_browser = null;
    public $device_browser_version = null;
    public $device_locale = null;
    public $device_platform = null;

    public $device_is_mobile = null;
    public $device_is_bot = null;
    public $device_client_is_valid = null;



/** +---------------+
 *  | DATA GROUPING |
 *  +---------------+*/
    public $device_array = Array();
    public $provider_array = Array();
    public $geo_array = Array();

    public $user_data = Array();

    /**
     * @param null $data        $filter = Array(
    'device_user_agent' => '',
    'ip_address' => '',
    'ip_host_name' => '',
    'device_cookie' => '',
    'device_accept_header' => '',
    'device_locale' => '',
    'ip_referrer' => '',
    'ip_request_method' => '',
    'ip_url' => ''
    );

     */
    public function get_all_data()
    {
        $this->user_data = array_merge(
            $this->get_device_data(),
            $this->get_provider_data(),
            $this->get_geo_data()
        );
        return $this->user_data ;
    }

    public function __construct($data = null)
    {

        /** +-------------------------+
         *  | Construct Verify Object |
         *  +-------------------------+
         *  We are either passed the information below, or we grab it from the server:
         *  • User Agent **[REQUIRED]
         *  • User IP address **[REQUIRED]
         *  • User Hostname **[REQUIRED]
         *  • User Cookie Value
         *  • User Accept Headers **[REQUIRED]
         *  • User Language
         *  • Request referrer
         *  • Request Method
         *  • Request URL
         */

        //If we are being passed an array of values, lets load it
        if(is_array($data))
        {
            foreach($data as $k=>$v)
            {
                if($k == 'ip_address')              $this->ip_address = $v;
                if($k == 'ip_referrer')             $this->ip_referrer = $v;
                if($k == 'ip_url')                  $this->ip_url = $v;
                if($k == 'ip_query_string')         $this->ip_query_string = $v;
                if($k == 'ip_hostname')             $this->ip_hostname = $v;
                if($k == 'ip_request_method')       $this->ip_request_method = $v;
                if($k == 'device_user_agent')       $this->device_user_agent = $v;
                if($k == 'ip_accept_header')        $this->ip_accept_header = $v;
                if($k == 'device_cookie')           $this->device_cookie = $v;
                if($k == 'device_locale')           $this->device_locale = $v;
            }
        }

        if(MODE == 'local' && !isset($this->ip_address)) $this->ip_address = generate_random_ip();
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strpos($_SERVER['HTTP_X_FORWARDED_FOR'],','))
        {
            $_set = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
            //$_SERVER['HTTP_X_FORWARDED_FOR']
            $this->ip_address = $_set[0];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && is_valid_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $this->ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $this->ip_hostname = (MODE == 'local')?$this->ip_address:$_SERVER['HTTP_X_FORWARDED_FOR'];


        //$this->ip_address           = ($this->ip_address != null)?$this->ip_address:$_SERVER['HTTP_X_FORWARDED_FOR'];
        $this->ip_referrer          = ($this->ip_referrer != null && isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:$this->ip_referrer;
        $this->ip_url               = ($this->ip_url != null)?$this->ip_url:($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $this->ip_query_string      = ($this->ip_query_string != null)?$this->ip_query_string:$_SERVER['QUERY_STRING'];



        //if((!isset($_SERVER['HTTP_X_FORWARDED_FOR']) || !is_valid_ip($_SERVER['HTTP_X_FORWARDED_FOR']) && (($this->ip_address == null) || !is_valid_ip($this->ip_address))))
        //$this->ip_hostname = $_SERVER['HTTP_X_FORWARDED_FOR'];//''; else $this->ip_hostname = ($this->ip_hostname != null)?$this->ip_hostname:'';//gethostbyaddr($this->ip_address);
        $this->ip_request_method    = ($this->ip_request_method != null)?$this->ip_request_method:strtolower($_SERVER['REQUEST_METHOD']);
        $this->device_user_agent    = ($this->device_user_agent != null)?$this->device_user_agent:$_SERVER['HTTP_USER_AGENT'];

        $this->setUserAgent($this->device_user_agent);

        $device_cookie = (isset($_SERVER['HTTP_COOKIE']) && !empty($_SERVER['HTTP_COOKIE']))?$_SERVER['HTTP_COOKIE']:"";
        $this->device_cookie        = ($this->device_cookie != null)?$this->device_cookie:cookie_string_to_array($device_cookie);

        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        //else if(isset($_SERVER['HTTP_ACCEPT'])) $accept_language = $_SERVER['HTTP_ACCEPT'];
        else $accept_language = "";

        $this->ip_accept_header = ($this->ip_accept_header != null)?$this->ip_accept_header:$accept_language;
        $this->device_locale        = ($this->device_locale != null)?$this->device_locale:$accept_language;

    }

    public function get_device_data()
    {


        $device_cookie = $this->device_cookie;
        $ip_accept_header = $this->ip_accept_header;
        $device_locale = $this->device_locale;

        $this->setUserAgent($this->device_user_agent);
        $device_os = $this->device_os = $this->getPlatform();
        switch($this->device_os)
        {
            case $this::PLATFORM_ANDROID:
                $device_platform = PLATFORM_ANDROID;
            break;

            case $this::PLATFORM_IPAD:
            case $this::PLATFORM_IPHONE:
            case $this::PLATFORM_IPOD:
                $device_platform = PLATFORM_IOS;
            break;

            case $this::PLATFORM_BEOS:
            case $this::PLATFORM_FREEBSD:
            case $this::PLATFORM_LINUX:
            case $this::PLATFORM_NETBSD:
            case $this::PLATFORM_NOKIA:
            case $this::PLATFORM_OPENBSD:
            case $this::PLATFORM_OPENSOLARIS:
            case $this::PLATFORM_OS2:
            case $this::PLATFORM_SUNOS:
                $device_platform = PLATFORM_LINUX;
            break;

            case $this::PLATFORM_MACINTOSH:
                $device_platform = PLATFORM_OSX;
            break;


            case $this::PLATFORM_WINDOWS:
            case $this::PLATFORM_WINDOWS_CE:
            case $this::PLATFORM_WINDOWS_PHONE:
                $device_platform = PLATFORM_WINDOWS;
            break;

            default:
            case $this::PLATFORM_UNKNOWN:
            case $this::PLATFORM_VERSION_UNKNOWN:
                $device_platform = PLATFORM_UNKNOWN;
            break;

         }

        $device_is_mobile = $this->device_is_mobile = $this->isMobile();
        $device_is_bot = $this->device_is_bot = $this->isRobot();

        $device_browser = $this->device_browser = $this->getName();
        //error_log("NAME: " . $device_browser);
        $device_browser_version = $this->device_browser_version = $this->getVersion();
        $device_os_version = $this->device_os_version = $this->getPlatformVersion();
        $device_user_agent = $this->device_user_agent;

        $device_client_is_valid = $this->device_client_is_valid = (isset($device_cookie['as_cs_qc'])?$device_cookie['as_cs_qc']:null);



        $this->device_array = Array(
            'device_cookie'=> $device_cookie,
            'ip_accept_header'=>$ip_accept_header,
            'device_locale'=>$device_locale,
            'device_os'=>$device_os,
            'device_platform'=>$device_platform,
            'device_os_version'=>$device_os_version,
            'device_browser'=>$device_browser,
            'device_browser_version'=>$device_browser_version,
            'device_is_bot'=>$device_is_bot,
            'device_is_mobile'=>$device_is_mobile,
            'device_client_is_valid'=>$device_client_is_valid,
            'device_user_agent'=>$device_user_agent,
        );

        return $this->device_array;
    }


    public function get_provider_data()
    {
        if($this->ip_address == null ) return Array();//false;
        /* +-----------+
         * | IP Domain |
         * +-----------+ */

        try{
        $reader = new Reader(SHARED_DATA_PATH . 'GeoIP2-Domain.mmdb');
        $record = $reader->domain($this->ip_address);
        $ip_domain = strtolower($record->domain);
        }catch(Exception $e)
        {
            $ip_domain = null;
        }
        $this->ip_domain = (!$ip_domain == null)?$ip_domain:false;;
        unset($reader);


        /* +------------------+
         * | Service Provider |
         * +------------------+ */
        $reader = new Reader(SHARED_DATA_PATH . 'GeoIP2-ISP.mmdb');
        try {
            $record = $reader->isp($this->ip_address);
            $ip_organization = strtolower($record->organization);
            $ip_provider = strtolower($record->isp);
            $ip_asn = strtolower($record->autonomousSystemNumber);
            $ip_asn_name = strtolower($record->autonomousSystemOrganization);
        }catch(Exception $e){
            $ip_organization = $ip_provider = $ip_asn = $ip_asn_name = null;
        }
        $this->ip_organization = (!$ip_organization == null)?$ip_organization:"";
        $this->ip_provider = (!$ip_provider == null)?$ip_provider:false;
        $this->ip_asn_name = (!$ip_asn_name == null)?$ip_asn_name:false;
        $this->ip_asn = (!$ip_asn == null)?$ip_asn:false;
        unset($reader);

        /* +-----------------+
         * | Connection Type |
         * +-----------------+ */
        $reader = new Reader(SHARED_DATA_PATH . 'GeoIP2-Connection-Type.mmdb');
        try {
            $record = $reader->connectionType($this->ip_address);
            $connection_type = strtolower($record->connectionType);
            //error_log('             connection:'. $connection_type);
            switch($connection_type)
            {
                case GEOIP_CONNECTION_DIALUP: $ip_connection = CONNECTION_DIALUP; break;
                case GEOIP_CONNECTION_CABLEDSL: $ip_connection = CONNECTION_CABLEDSL; break;
                case GEOIP_CONNECTION_CORPORATE: $ip_connection = CONNECTION_CORPORATE; break;
                case GEOIP_CONNECTION_CELLULAR: $ip_connection = CONNECTION_CELLULAR; break;
                default:
                case GEOIP_CONNECTION_UNKNOWN_SPEED: $ip_connection = CONNECTION_UNKNOWN; break;
            }
        }
        catch(Exception $e)
        {
            $ip_connection = CONNECTION_UNKNOWN;
        }

        $this->ip_connection = $ip_connection; //connection type / also org type
        unset($reader);

        $this->provider_array = Array(
        'ip_organization'=>$this->ip_organization,
        'ip_provider'=>$this->ip_provider,
        'ip_asn'=>$this->ip_asn,
        'ip_asn_name'=>$this->ip_asn_name,
        'ip_domain'=>$this->ip_domain,
        'ip_connection'=>$this->ip_connection,
        'ip_request_method'=>$this->ip_request_method,
        'ip_referrer'=>$this->ip_referrer,
        'ip_host_name'=>$this->ip_hostname,
        'ip_url'=>$this->ip_url
        );

        return $this->provider_array;
    }

    public function merge_data()
    {
        $this->user_data = array_merge($this->device_array,$this->provider_array,$this->geo_array);
        return $this->user_data;
    }

    public function get_geo_data()
    {
        if($this->ip_address == null || !is_valid_ip($this->ip_address)) return Array();

        /* +-------------+
         * | Geolocation |
         * +-------------+ */
        $reader = new Reader(SHARED_DATA_PATH . 'GeoIP2-City.mmdb');
        try {
            $record = $reader->city($this->ip_address); //12.33.243.26
            $ip_country = strtolower($record->country->isoCode);
            $ip_city = strtolower($record->city->name);
            $ip_location = strtolower($record->mostSpecificSubdivision->isoCode);
            $ip_postal_code = strtolower($record->postal->code);

            /*
            $origin_dtz = new DateTimeZone("utc");
            $remote_dtz = new DateTimeZone($record->location->timeZone);
            $origin_dt = new DateTime("now", $origin_dtz);
            $remote_dt = new DateTime("now", $remote_dtz);
            $ip_timezone = ($origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt))/60;
            unset($origin_dt);
            unset($remote_dtz);
            unset($origin_dt);
            unset($remove_dt);*/
            //exit('utc ' . $record->location->timeZone . 'offset:' . $ip_timezone);

            //exit('<pre>'.print_r($record->location,true) . 'offset:' . $tz);

        } catch(Exception $e)
        {
            $ip_country = $ip_city = $ip_location = $ip_postal_code = null;
        }
        $this->ip_country = (!$ip_country == null)?$ip_country:false;
        $this->ip_city =  (!$ip_city == null)?$ip_city:false;
        $this->ip_location = (!$ip_location == null)?$ip_location:false;
        $this->ip_postal_code =  (!$ip_postal_code == null)?$ip_postal_code:false;
        $this->ip_timezone = '';//$ip_timezone;//(!$record->location->timeZone !== null)?$ip_timezone:false;
        unset($reader);

        $this->geo_array = Array(
            'ip_country'=>$this->ip_country,
            'ip_city'=>$this->ip_city,
            'ip_location'=>$this->ip_location,
            'ip_postal_code'=>$this->ip_postal_code,
            'ip_timezone'=>$this->ip_timezone
        );

        return $this->geo_array;
    }


}
