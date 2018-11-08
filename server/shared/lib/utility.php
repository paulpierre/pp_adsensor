<?php

function cookie_string_to_array($cookie_string=null)
{
    if(!$cookie_string) return false;
    //$cookie_string = '_ga=GA1.2.1838254826.1477528233; as_fp=55; as_vc=78; as_cs_qc=-1; as_ss_qc=1';
    $line = explode(';',trim($cookie_string));
    foreach($line as $cookie)
    {
        $v = explode('=',trim($cookie));
        $cookie_array[$v[0]] = $v[1];
    }
    return $cookie_array;
}


function isJson($string) {
    return ((is_string($string) &&
        (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
}

function current_timestamp()
{
    return date("Y/m/d H:i:s");
}

function replace_strings($source,$array)
{
    if(!is_array($array)) return false;
    foreach ($array as $k=>$v)
    {
        $source = str_replace($k,$v,$source);
    }
    return $source;
}

function generate_random_ip()
{
    $result = "";
    for ($a = 0; $a < 4; $a++) {
        if ($a > 0) {
            $result = $result . ".";
        }
        $a2 = rand(1, 254);
        $result = $result . $a2;
    }
    return $result;
}

function is_valid_ip($ip)
{
    return (filter_var($ip, FILTER_VALIDATE_IP))?true:false;
}

function duration($etime) {

    if ($etime < 1) {
        return 'just now';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}


 function time_ago($ptime) {
    $etime = time() - $ptime;

    if ($etime < 1) {
        return 'just now';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = number_format($d,1);
            return $r . ' ' . $str . ($r > 1 ? 's' : '');
        }
    }
}

 function aasort (&$array, $key, $sortType=SORT_DESC) {
    if(empty($array)) return true;
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    if($sortType == SORT_DESC)
    {$array=array_reverse($ret,true);}
}

function as_error($error_message)
{
    if(ENABLE_LOGS) error_log($error_message);
}

function obfuscate_js($js,$type = OBFUSCATE_PACKER )
{
    switch($type) {

        case OBFUSCATE_ENCRYPTION:
            $config = new wlJSOConfig();            //create a configuration and fill its values
            $config->DO_DECOY = false;
            $config->DO_MINIFY = true;
            $config->DO_LOCK_DOMAIN = false;
            $config->DO_SCRAMBLE_VARS = true;
            $config->ENCRYPTION_LEVEL = 1;
            $config->SHOW_JS_LOCK_ALERTS = false;
            $config->CACHE_LEVEL = 0;
            $config->SHOW_WISELOOP_SIGNATURE = false;

            $jso = new wlJSOProcessor();
            $jso->init($js, $config);
            $res = $jso->get();
            unset($jso);
            unset($config);
            return $res;
            break;

        case OBFUSCATE_NONE:
            return $js;
            break;

        case OBFUSCATE_PACKER: default:
        $packer = new Packer($js, 'Normal', true, false, true);
        $packed_js = $packer->pack();
        $res = $packed_js;
        unset($packer);
        return $res;
        break;
    }
}

function get_platform()
{
    if( stripos($_SERVER['HTTP_USER_AGENT'],"iPod") || stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") || stripos($_SERVER['HTTP_USER_AGENT'],"iPad"))
        return PLATFORM_IOS;
        else if (stripos($_SERVER['HTTP_USER_AGENT'],"Android"))
            return PLATFORM_ANDROID;
    else  return PLATFORM_UNKNOWN;
}

function show_error()
{
    header('HTTP/1.0 404 Not Found');
    $_html = <<<EOF
<!DOCTYPE html>
<html>
<head>
    <title>404 Not Found</title>
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex">
    <meta name="referrer" content="no-referrer" />
</head>
<body>
    <h1>404</h1>
    <h3>Not found</h3>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86126953-1', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
EOF;
    exit($_html);

}




