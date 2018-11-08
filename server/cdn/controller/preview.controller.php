<?php
global $controllerObject,$controllerFunction,$controllerID,$controllerData,$controllerData2,$controllerData3, $app_path,$cm_banner ;

   /** ======
    *  PREVIEW
    *  ======

    *  Displays the source code for the animation code, can be linked if advertiser allows remote linking
    */




$campaign_advertiser = $controllerFunction;
$campaign_identifier = $controllerID;
$preview_type = $controllerData;  

include_once(HELPER_PATH . 'ad_tag.helper.php');

//display_tag()
if(!isset($cm_banner[$campaign_identifier]) ||
    strtolower($cm_banner[$campaign_identifier]['advertiser']) != strtolower($campaign_advertiser))
{
    show_error();
} else
if($controllerData == 'mraid.js') exit(); else
    if($controllerData == 'tag')  header('Content-type: text/plain');
else
    header('Content-type: text/html');

exit(display_tag());
