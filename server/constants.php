<?php

//for environment purposes
define('MODE',(isset($_SERVER['MODE']))?$_SERVER['MODE']:'prod');
//define('MODE','local');




/** ========
 *  NETWORKS
 *  ========
 */
define('DEBUG',false);
define('NETWORK_TAPSOMNIA',0);
define('NETWORK_AIRPUSH',1);
define('NETWORK_POCKETMATH',2);
define('NETWORK_EXOCLICK',3);
define('NETWORK_GOOGLE_ADWORDS',4);
define('NETWORK_ADCASH',5);
define('NETWORK_THIRD_PARTY',6);
define('NETWORK_ACQUITY_ADS',7);

/** ==============
 *  ERROR MESSAGES
 *  ==============
 */

define('ERROR_INVALID_PARAMETERS','Invalid parameters passed');
define('ERROR_INVALID_OBJECT','Invalid object');
define('ERROR_INVALID_USER_ID','Invalid ID for object');
define('ERROR_INVALID_FUNCTION','Invalid object function');
define('ERROR_NO_DATA_AVAILABLE','No data available for object');
define('ERROR_PARSING_DATA','An internal error occurred attempting to parse the data from the source');

/** =============
 *  MODEL CLASSES
 *  =============
 */
define('SERIALIZE_DATABASE',0);
define('SERIALIZE_JSON',1);

/** ==============
 *  RESPONSE CODES
 *  ==============
 */
define('RESPONSE_SUCCESS',1);
define('RESPONSE_ERROR',0);


/** ==================
 *  IP CONNECTION TYPE
 *  ==================
 */
define('CONNECTION_UNKNOWN',0);
define('CONNECTION_DIALUP',1);
define('CONNECTION_CABLEDSL',2);
define('CONNECTION_CORPORATE',3);
define('CONNECTION_CELLULAR',4);

/** ======================
 *  DEVICE IDENTIFIER TYPE
 *  ======================
 */
define('DEVICE_TYPE_UNKNOWN',0);
define('DEVICE_TYPE_GOOGLE_ADVERTISER_ID',1);
define('DEVICE_TYPE_IOS_ADVERTISER_ID',2);
define('DEVICE_TYPE_UDID',3);

/** =========================
 *  DEVICE FILTERING/CLOAKING
 *  =========================
 */
define('FILTER_FLAG_WHITE_LIST',1);
define('FILTER_FLAG_BLACK_LIST',2);

define('GEOIP_CONNECTION_DIALUP','dialup');
define('GEOIP_CONNECTION_CELLULAR','cellular');
define('GEOIP_CONNECTION_CABLEDSL','cable/dsl');
define('GEOIP_CONNECTION_CORPORATE','corporate');
define('GEOIP_CONNECTION_UNKNOWN_SPEED',null);


/** ==================
 *  HTML/CSS/JS ASSETS
 *  ==================
 */
//Javascript security level
define('OBFUSCATE_NONE',0);
define('OBFUSCATE_PACKER',1);
define('OBFUSCATE_ENCRYPTION',2);

//Tag generation flags
define('BANNER_TAG_HTML_FULL',0);
define('BANNER_TAG_HTML_NO_JS',1);

define('BANNER_TAG_HTML_PREVIEW',2);
define('BANNER_TAG_ANIMATEJS',3);
define('BANNER_TAG_HTML_FULL_AIRPUSH',4);


/** ==========================
 *  MACROS FOR HTML5/JS ASSETS
 *  ========================== */
define('AS_BANNER_WIDTH','{AS_BANNER_WIDTH}');
define('AS_BANNER_HEIGHT','{AS_BANNER_HEIGHT}');
define('AS_CAMPAIGN_NAME','{AS_CAMPAIGN_NAME}');
define('AS_IMG_ROOT','{AS_IMG_ROOT}');
define('AS_CM_IMAGES_JS','{AS_CM_IMAGES_JS}');
define('AS_CM_IMAGES_HTML','{AS_CM_IMAGES_HTML}');
define('AS_BANNER_VIDEO_URL','{AS_BANNER_VIDEO_URL}');
define('AS_BANNER_CLICK_URL','{AS_BANNER_CLICK_URL}');
define('AS_JS_REDIRECT_CODE','{AS_JS_REDIRECT_CODE}');
define('AS_CAMPAIGN_ROOT_PATH','{AS_CAMPAIGN_ROOT_PATH}');
define('AS_JS_ADSENSOR_SRC','{AS_JS_ADSENSOR_SRC}');
define('AS_JS_ADSENSOR_URL','{AS_JS_ADSENSOR_URL}');
define('AS_JS_ADSENSOR_MRAID_SRC','{AS_JS_ADSENSOR_MRAID_SRC}');
define('AS_JS_ADSENSOR_MRAID_URL','{AS_JS_ADSENSOR_MRAID_URL}');
define('AS_JS_ANIMATION_SRC','{AS_JS_ANIMATION_SRC}');
define('AS_JS_ANIMATION_URL','{AS_JS_ANIMATION_URL}');
define('AS_CSS_ANIMATION_URL','{AS_CSS_ANIMATION_URL}');
define('AS_CSS_ANIMATION_SRC','{AS_CSS_ANIMATION_SRC}');
define('AS_ROOT_DOMAIN','{AS_ROOT_DOMAIN}');
define('AS_CDN_CAMPAIGN_ROOT_PATH','{AS_CDN_CAMPAIGN_ROOT_PATH}');
define('AS_DOMAIN','{AS_DOMAIN}');
define('AS_TRACKER_DOMAIN','{AS_TRACKER_DOMAIN}');
define('AS_COOKIE_DOMAIN','{AS_COOKIE_DOMAIN}');
define('AS_JS_BANNER_SRC','{AS_JS_BANNER_SRC}');
define('AS_JS_BANNER_URL','{AS_JS_BANNER_URL}');


/** ===================================================
 *  STANDARDIZED FLAGS FOR THE FILTERING IN THE CLOAKER
 *  =================================================== */
define('FILTER_FLAG_BLOCK_FACEBOOK_ALL',0);     //Blocks all Facebook IPs, hostnames and ASNs
define('FILTER_FLAG_BLOCK_GOOGLE_ALL',1);       //Blocks all Google IPs, hostnames and ASNS
define('FILTER_FLAG_BLOCK_BOTS',2);             //Blocks all bot traffic
define('FILTER_FLAG_BLOCK_AD_REVIEWER',3);      //Blocks all known ad reviewer traffic IPs and hostnames
define('FILTER_FLAG_BLOCK_PROXY',4);
define('FILTER_FLAG_BLOCK_BLANK_REFERRER',5);


/** =================
 *  OPERATING SYSTEMS
 *  ================= */

define('PLATFORM_ANDROID',2);
define('PLATFORM_IOS',1);
define('PLATFORM_LINUX',5);
define('PLATFORM_WINDOWS',3);
define('PLATFORM_OSX',4);
define('PLATFORM_UNKNOWN',6);



define('CACHE_DURATION',10800);
define('COOKIE_EXPIRATION',time() + (10 * 365 * 24 * 60 * 60));


/** ===========
 *  REDIRECTION
 *  ===========
 */
define('COOKIE_ACTION_LIMIT',999); //do the action twice every 12
//define('COOKIE_ACTION_EXPIRATION',time() + (60*12 *60)); //every 12 hours
define('COOKIE_ACTION_EXPIRATION',time() + (60*12 *60)); //every 12 hours

/** ====================
 *  CM FREQUENCY CAPPING
 *  ====================
 */

define('COOKIE_FREQUENCY_CAP_EXPIRATION',time() + (60 * 60 *24*3)); //every 3 days