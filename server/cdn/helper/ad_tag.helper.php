<?php


/** ----------------------------------------------------------
 *  Lets setup the variables to be used by all these functions
 *  ---------------------------------------------------------- */
global $app_path,
       $cm_banner,
       $campaign_advertiser,
       $campaign_identifier,
        $sub_domain,
       $campaign_banner_image;
switch(MODE)
{
        case 'local':
            $cdn_host = $_SERVER['SERVER_NAME'];
        break;

        default:
        case 'prod':
    $cdn_host = replace_strings($_SERVER['SERVER_NAME'],Array(
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',
        '#########'=>'#########',

    ));
}

$protocol = (isset($cm_banner[$campaign_identifier]['is_ssl']) && $banner_images = $cm_banner[$campaign_identifier]['is_ssl'])?'https://':'http://';


//$cdn_host = $_SERVER['SERVER_NAME'];
//if(MODE == "local")
//{

    //is_ssl

    $cdn_campaign_root_path = $protocol . $cdn_host . '/banner/' . $campaign_advertiser . '/' . $campaign_identifier . '/';
    //AS_CDN_CAMPAIGN_ROOT_PATH
    $root_url = $protocol . $_SERVER['SERVER_NAME'] . '/';
    //$root_url = 'http://' . str_replace("cdn","cdn2",$_SERVER['SERVER_NAME']) .  '/';


    $cdn_path = $protocol . $cdn_host .  '/';

/*
} else {
    $cdn_campaign_root_path = 'http://' . CDN_HOST . '/banner/' . $campaign_advertiser . '/' . $campaign_identifier . '/';
    //$root_url = 'https://' . str_replace("cdn.","cdn2.",$_SERVER['SERVER_NAME']) .  '/';
    $root_url = 'http://' . $_SERVER['SERVER_NAME'] . '/';

    $cdn_path = "http://" . str_replace("cdn.","cdn2.",$_SERVER['SERVER_NAME']) .  '/';


}*/


$root_path = $app_path;
$campaign_root_path = $root_url . 'banner/'.$campaign_advertiser . '/' . $campaign_identifier . '/';
$banner_asset_path = $root_path . 'banner/' . $campaign_advertiser . '/' . $campaign_identifier . '/';
//http://d1u2gws3p09192.cloudfront.net/banner/autoinsurance/ap-auto-app-300x250-122616/bg.jpg





function display_tag()
{
    global $banner_asset_path;
    $raw_html = file_get_contents($banner_asset_path . 'banner.html');

    $res = replace_strings($raw_html, Array(
        AS_CSS_ANIMATION_URL=>get_macro(AS_CSS_ANIMATION_URL),
        AS_CSS_ANIMATION_SRC=>get_macro(AS_CSS_ANIMATION_SRC),
        AS_JS_ADSENSOR_SRC=>get_macro(AS_JS_ADSENSOR_SRC),
        AS_JS_ADSENSOR_MRAID_SRC=>get_macro(AS_JS_ADSENSOR_MRAID_SRC),
        AS_JS_ADSENSOR_URL=>get_macro(AS_JS_ADSENSOR_URL),
        AS_JS_ADSENSOR_MRAID_URL=>get_macro(AS_JS_ADSENSOR_MRAID_URL),
        AS_JS_ANIMATION_SRC=>get_macro(AS_JS_ANIMATION_SRC),
        AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
        AS_CM_IMAGES_HTML=>get_macro(AS_CM_IMAGES_HTML),
        AS_CDN_CAMPAIGN_ROOT_PATH=>get_macro(AS_CDN_CAMPAIGN_ROOT_PATH),
        AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
        AS_JS_BANNER_URL=>get_macro(AS_JS_BANNER_URL),

        //AS_JS_REDIRECT_CODE=>get_macro(AS_JS_REDIRECT_CODE),
        AS_BANNER_CLICK_URL=>get_macro(AS_BANNER_CLICK_URL)
    ));
    return $res;

    /*
    switch ($tag_type) {

        case BANNER_TAG_HTML_FULL:
            return generate_html_tag();
        break;
        case BANNER_TAG_HTML_NO_JS:
            return generate_html_no_js();
        break;
        case BANNER_TAG_HTML_PREVIEW:
            return generate_html_tag();
        break;
        case BANNER_TAG_ANIMATEJS:
            return generate_animate_js();
        break;

        case BANNER_TAG_HTML_FULL_AIRPUSH:
            return generate_html_tag_3k();
        break;

        default:
        break;
    }*/
}



function get_macro($macro_name,$macro_options = Array())
{
    global $campaign_advertiser,
           $protocol,
           $campaign_identifier,
           $root_url,
           $campaign_root_path,
           $cdn_campaign_root_path,
           $cm_banner,
           $banner_asset_path,
           $cdn_path,
            $sub_domain,
           $root_path;

    //Lets deal with any option flags
    if(!empty($macro_options))
    {
        if(in_array(OBFUSCATE_PACKER,$macro_options)) $js_output_type = 'mn';
        else if(in_array(OBFUSCATE_ENCRYPTION,$macro_options)) $js_output_type = 'en';
        else $js_output_type = 'pt';
    }



    switch($macro_name)
    {
        case AS_ROOT_DOMAIN:
            return $root_url;
        break;

        case AS_BANNER_WIDTH:
            return $cm_banner[$campaign_identifier]['width'];
        break;

        case AS_BANNER_HEIGHT:
            return $cm_banner[$campaign_identifier]['height'];
        break;

        case AS_CAMPAIGN_NAME:
            return $cm_banner[$campaign_identifier]['name'];
        break;

        case AS_CM_IMAGES_JS:
            $user_platform = get_platform();
            if($user_platform == PLATFORM_UNKNOWN) $user_platform = PLATFORM_ANDROID;
            $banner_images = $cm_banner[$campaign_identifier]['images'][$user_platform];
            $img = '';
            end($banner_images);
            $last_key =  key($banner_images);
            foreach($banner_images as $k=>$v)
            {$img .= '{"i":"'.$k .'","d":0,"c":"bounce"}' . (($last_key != $k)?(',' . PHP_EOL . '        '):'');}
            //error_log($img);
            return $img;
        break;

        case AS_CM_IMAGES_HTML:
            $user_platform = get_platform();
            if($user_platform == PLATFORM_UNKNOWN) $user_platform = PLATFORM_ANDROID;
            $cm_images = $cm_banner[$campaign_identifier]['images'][$user_platform];
            $res = '';
            foreach($cm_images as $k=>$v)
            {
                $res .='<img id="dd-' . rtrim($k,".png") .'" class="dd_img"/>';
            }
            return $res;
        break;

        case AS_BANNER_VIDEO_URL:
            return (isset($cm_banner[$campaign_identifier]['video_url'])?$cm_banner[$campaign_identifier]['video_url']:'');
        break;

        case AS_BANNER_CLICK_URL:
            return $cm_banner[$campaign_identifier]['click_url'] . '&note=' . $campaign_identifier . '&nid=' . $cm_banner[$campaign_identifier]['network'];
        break;

        case AS_JS_REDIRECT_CODE:

            //error_log($campaign_identifier . ' - ' . $cm_banner[$campaign_identifier]['is_redirect'] );

            if(!$cm_banner[$campaign_identifier]['is_redirect']) return '';

            /** ===========================================
             *  SERVER SIDE FILTER FOR JAVASCRIPT REDIRECTS
             *  =========================================== */
            $verify_instance = new Filter();
            if(isset($cm_banner[$campaign_identifier]['filter']) && !empty($cm_banner[$campaign_identifier]['filter']))
            {
                $verify_instance->set_filter($cm_banner[$campaign_identifier]['filter']);
                $is_verified = $verify_instance->is_verified();

            } else {
                $is_verified = true;
            }

            //error_log("is_verified: " . ($is_verified)?'true':'false');


            $user_fingerprint = isset($_COOKIE['as_fp']) && $_COOKIE['as_fp'] != ''?$_COOKIE['as_fp']:false;
            $_script = '';
            if($is_verified && ((isset($_COOKIE['as_ctr']) && isset($_COOKIE['as_lmt'])) && (intval($_COOKIE['as_ctr']) < intval($_COOKIE['as_lmt'])))) {
                //error_log("###COOKIE COMPARISON: as_ctr: " . $_COOKIE['as_ctr'] .  ' as_lmt:' . $_COOKIE['as_lmt']);
                $domain =  $sub_domain[1] . '.' . $sub_domain[2];
                if(isset($_COOKIE['as_ss_qc']) && intval($_COOKIE['as_ss_qc']))
                    setcookie('as_ss_qc',  1 , COOKIE_EXPIRATION,'/',$domain,false); //the user's fingerprint

                //$campaign_data = (isset($_SERVER['QUERY_STRING']))?$_SERVER['QUERY_STRING']:'';

                $_url = base64_encode($cm_banner[$campaign_identifier]['redirect_url']);// . '/?' . $campaign_data . (($user_fingerprint)?('&fp=' . $user_fingerprint):'')) ;

                $_script = '
                if(window.$asqc == true && "atob" in $[0])
                {
                    as_inc_ctr();
                    setTimeout(function(){
                        $[0][$[24]].replace($[0].atob("'. $_url. '") + _qs[0] + "' .'&fp=' . $user_fingerprint . '");
                    },1500);
                }';
                //error_log($_SERVER['REQUEST_URI']);
            } ;
            //error_log($_script);

            return $_script;
        break;

        case AS_CAMPAIGN_ROOT_PATH:
            return  $campaign_root_path;
        break;

        case AS_DOMAIN:
            return $_SERVER['SERVER_NAME'];
        break;

        case AS_TRACKER_DOMAIN:

                 $track_domain = replace_strings($_SERVER['SERVER_NAME'],Array(
                     'cdn.razorcdn'=>'track.razorcdn',
                     'cdn.adsensor'=>'track.adsensor',
                     'cdn.firecdn'=>'track.firecdn',
                     'cdn.sushicdn'=>'track.sushicdn',
                     'cdn.famoustrkads'=>'track.famoustrkads',
                     'cdn.media-mob.in'=>'track.media-mob.in',
                     'files.offertrx.co'=>'trk.offertrx.co',
                     's3.clickmark.co'=>'trk2.clickmark.co'
                 ));
            return $protocol . $track_domain . '/';
                //'http://'. str_replace('cdn.r','track.r',$_SERVER['SERVER_NAME']) . '/';
        break;

        case AS_COOKIE_DOMAIN:

             return replace_strings($_SERVER['SERVER_NAME'],Array(
                'cdn.razorcdn'=>'.razorcdn',
                'cdn.adsensor'=>'.adsensor',
                'cdn.firecdn'=>'.firecdn',
                 'cdn.sushicdn'=>'.sushicdn',
                 'cdn.famoustrkads'=>'.famoustrkads',
                 'cdn.media-mob'=>'.media-mob',
                 'files.offertrx'=>'.offertrx',
                 's3.clickmark.co'=>'.clickmark'
            ));

            break;

        case AS_CDN_CAMPAIGN_ROOT_PATH:
            return $cdn_campaign_root_path;
        break;
        case AS_JS_ADSENSOR_SRC:
            $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($root_path . 'assets/js/production.adsensor.tracker.v2.js'));
            return obfuscate_js($js,isset($js_output_type)?$js_output_type:'pt');
        break;

        case AS_JS_ADSENSOR_URL:
            return $cdn_path . 'sdk/' . (isset($js_output_type)?$js_output_type:'pt') . '/impression_tracker.sdk-v2.js';
        break;

        case AS_JS_ADSENSOR_MRAID_SRC:
            $js = str_replace('{AS_ROOT_DOMAIN}',str_replace('cdn','track',$root_url),file_get_contents($root_path . 'assets/js/production.adsensor.tracker.mraid.js'));
            return obfuscate_js($js,isset($js_output_type)?$js_output_type:'pt');
        break;

        case AS_JS_ADSENSOR_MRAID_URL:
            return $cdn_path . 'sdk/' . (isset($js_output_type)?$js_output_type:'pt') . '/impression_tracker.sdk-v1-mraid.js';
        break;



        case AS_JS_ANIMATION_SRC:
            $raw_js = file_get_contents($banner_asset_path . 'animate.js');

            $res = replace_strings($raw_js, Array(
                AS_BANNER_WIDTH=>get_macro(AS_BANNER_WIDTH),
                AS_BANNER_HEIGHT=>get_macro(AS_BANNER_HEIGHT),
                AS_CAMPAIGN_NAME=>get_macro(AS_CAMPAIGN_NAME),
                AS_IMG_ROOT=>get_macro(AS_IMG_ROOT),
                AS_CM_IMAGES_JS=>get_macro(AS_CM_IMAGES_JS),
                AS_BANNER_VIDEO_URL=>get_macro(AS_BANNER_VIDEO_URL),
                AS_BANNER_CLICK_URL=>get_macro(AS_BANNER_CLICK_URL),
                AS_JS_REDIRECT_CODE=>get_macro(AS_JS_REDIRECT_CODE),
                AS_JS_ADSENSOR_MRAID_URL=>get_macro(AS_JS_ADSENSOR_MRAID_URL),
                AS_JS_ADSENSOR_URL=>get_macro(AS_JS_ADSENSOR_URL),
                AS_CAMPAIGN_ROOT_PATH=>get_macro(AS_CAMPAIGN_ROOT_PATH),
                AS_CDN_CAMPAIGN_ROOT_PATH=>get_macro(AS_CDN_CAMPAIGN_ROOT_PATH)
            ));
            return $res;
        break;


        case AS_JS_BANNER_SRC:
            $raw_js = file_get_contents($banner_asset_path . 'banner.js');

            $res = replace_strings($raw_js, Array(

                AS_CM_IMAGES_JS=>get_macro(AS_CM_IMAGES_JS),
                AS_JS_ADSENSOR_MRAID_URL=>get_macro(AS_JS_ADSENSOR_MRAID_URL),
                AS_JS_ADSENSOR_URL=>get_macro(AS_JS_ADSENSOR_URL),
                AS_CAMPAIGN_ROOT_PATH=>get_macro(AS_CAMPAIGN_ROOT_PATH),
                AS_CM_IMAGES_HTML=>get_macro(AS_CM_IMAGES_HTML),
                AS_JS_ANIMATION_URL=>get_macro(AS_JS_ANIMATION_URL),
                AS_CSS_ANIMATION_URL=>get_macro(AS_CSS_ANIMATION_URL),
                AS_ROOT_DOMAIN=>get_macro(AS_ROOT_DOMAIN),
            ));
            return $res;
        break;

        case AS_JS_ANIMATION_URL:
            return $campaign_root_path . 'animate.js';
        break;

        case AS_JS_BANNER_URL:
            return $campaign_root_path . 'banner.js';
            break;

        case AS_CSS_ANIMATION_URL:
            return $campaign_root_path . 'banner.css';
        break;

        case AS_CSS_ANIMATION_SRC:
            $raw_css = file_get_contents($banner_asset_path . 'banner.css');

            $res = replace_strings($raw_css, Array(
                AS_CAMPAIGN_ROOT_PATH=>get_macro(AS_CAMPAIGN_ROOT_PATH),
                AS_CDN_CAMPAIGN_ROOT_PATH=>get_macro(AS_CDN_CAMPAIGN_ROOT_PATH)
            ));
            return $res;
        break;

        default:
            return '';
        break;
    }
}