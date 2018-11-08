/** +----------------------------------------+
 *  | FraudBlock - Tag Generator SDK v0.3.5  |
 *  +----------------------------------------+
 *  Impression Tracking and Fraud Prevention Javascript SDK
 *  --
 *  paul@pixel6.net
 */

as_click_url = document.getElementById("as_url").href;


//Define and include MRAID.js and lets set a flag whether this adunit is MRAID compliant or not
var  is_mraid;as_start = Math.floor(Date.now());
var $, _;
document.addEventListener("DOMContentLoaded",(function () {
    is_mraid = typeof mraid !== "undefined";
    $ = [
        window,                 //  $[0]
        navigator,              //  $[1]
        screen,                 //  $[2]
        "function",             //  $[3]
        "ontouchstart",         //  $[4]
        "devicePixelRatio",     //  $[5]
        "colorDepth",           //  $[6]
        "screen",               //  $[7]
        document,               //  $[8]
        "createTouch",          //  $[9]
        window.screen,          //  $[10]
        "orientation",          //  $[11]
        "portrait-primary",     //  $[12]
        history,                //  $[13]
        "language",             //  $[14]
        "plugins",              //  $[15]
        "mimeTypes",            //  $[16]
        "connection",           //  $[17]
        24,                     //  $[18]
        1441,                   //  $[19]
        new Image,              //  $[20]
        "https://##########/tag/banner.js", //  $[21]
        window.location.href,   //  $[22]
        "cookie",               //  $[23]  $[8].$[23]
        "location",             //  $[24]
        "href",                 //  $[25]
        "deviceorientation",    //  $[26]
        "undefined",            //  $[27]
        "resize",                //  $[28]
        "buildID"               // $[29]
    ];

    _ = {
        "ua":encodeURIComponent($[1].userAgent),
        "tch":($[4] in $[0])?1:-1,
        "pr":($[5] in $[0] && $[0].devicePixelRatio > 1)?parseFloat($[0].devicePixelRatio).toFixed(2):-.1,
        "dp":($[6] in $[2])?$[2].colorDepth:-1,
        "sw":($[7] in $[0])?$[2].width:-1,
        "sh":($[7] in $[0])?$[2].height:-1,
        "hc":($[1].hardwareConcurrency)?1:-1,
        "mtch":($[1].maxTouchPoints)?$[1].maxTouchPoints:-1,
        "ct":($[9] in $[8])?1:-1,
        "oc":$[11] in $[10]?1:-1,
        "or":($[11] in $[10])?($[10].orientation==$[12]?1:2):-1,
        "hl":($[13] && $[13].length > 0)?$[13].length:-1,
        "la":($[14] in $[1])?$[1].language:"",
        "pl":($[15] in $[1])?$[1].plugins.length:-1,
        "mt":($[16] in $[1])?$[1].mimeTypes.length:-1,
        "cn":($[17] in $[1])?$[1].connection.type:"",
        "ts":Math.floor(Date.now()/1000),
        "actx":($[0].AudioContext || $[0].webkitAudioContext)?1:-1,
        "u":encodeURIComponent($[22]),
        "ck":($[1].cookieEnabled)?1:-1,
        "tz":(new Date).getTimezoneOffset(),
        "cst":($[8].charset || $[8].characterSet),
        "dvt":(($[0].outerHeight - $[0].innerHeight) > 100)?-1:1,
        "n_res":(($[2].width < $[2].availWidth) || ($[2].height < $[2].availHeight))?-1:1,
        "bid": ($[29] in $[1] && $[1][$[29]] != $[27])?$[1][$[29]]:-1
    };

    /*  ============================================
     *  Disable debuggers from messing with our code
     *  ============================================ */
    if(_.dvt) {
        setInterval(function(){(eval("debugger;//\uD83D\uDE2D\uD83D\uDE2D\uD83D\uDE2D\uD83D\uDE2D\uD83D\uDE2D\n"))},10)
    };

    /*  =============================
     *  Browser manipulated languages
     *  ============================= */

    _["n_la"] = (function(){
        if(typeof $[1].languages !== $[27]){
            try {
                var firstLanguages = $[1].languages[0].substr(0, 2);
                if(firstLanguages !== $[1].$[14].substr(0, 2)){
                    return -1;
                }
            } catch(err) {
                return -1;
            }
        }
        return 1;
    })(_);


    /*  ====================
     *  Voluum campaign NOTE
     *  ==================== */

    _["nt"] = (function(){
        try {
            if(typeof as_click_url != $[27])
            {
                var i = as_click_url.match(/(note=)([0-9a-zA-z-]+)(&|$)/i);
            }
            if(i !== null)  return i[2];
            else return "";
        } catch(e){ return "";}
    })(_);

    /** ======
     *  Domain
     *  ======
     */
    _["dom"] = (function(){
        try {
            var _scr = document.getElementsByTagName('script');
            var _dom = _scr[_scr.length - 1].src;
            return btoa(_dom.match(new RegExp('https?://([^/]*)'))[1]);
        } catch(e){ return "";}
    })(_);




    /*  ================
     *  Browser referrer
     *  ================ */

    _["ref"] = (function() {
        var _$;
        try {_$ = $[0].top.document.referrer;} catch (_) {if ($[0].parent) {try {_$ = $[0].parent.document.referrer;} catch (_) {}}}
        return "" != _$ ? encodeURIComponent(_$) : "";
    })();

    /*  ======================
     *  Browser OS 1=ios 2=and
     *  ====================== */

    _["os"] = (function() {
        if ((/iPhone/.test(_.ua)) || (/iPad/.test(_.ua))) return 1;
        else if (/Android/.test(_.ua)) return 2;
        else return -1;
    })();



    /*  ====================
     *  Click link device_id
     *  ==================== */
    _["did"] = (function(){
        var i = _["ref"].match(/(udid|ifa|idfa|gaid|androidid|deviceid|advertid)=([0-9A-Fa-f-]+)/i);
        if(i == null && typeof dd_click_url != $[27])
        {
            i = dd_click_url.match(/(udid|idfa|ifa|gaid|androidid|deviceid|advertid)=([0-9A-Fa-f-]+)/i);
        }
        if(i !== null)  return i[2];
        else return "";
    })(_);

    /*  ==================
     *  Voluum campaign_id
     *  ================== */
    _["cid"] = (function(){
        var i = $[22].match(/(campid)=([0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12})/i);
        if(i !== null) return i[2];
        else return "";
    })($);


    /*  ==============
     *  Voluum zone_id
     *  ============== */
    _["zid"] = (function(){
        var i = $[22].match(/(zid=)([0-9a-z]+)(&|$)/i);
        if(i !== null) return i[2];
        else return "";
    })($);


    /*  ==================
     *  Device Mac address
     *  ================== */
    _["mc"] = (function(){
        var i = _["u"].match(/([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/);
        if(i !== null) return i[0];
        else i = _["ref"].match(/([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/);
        if(i !== null) return i[0];
        else return "";
    })(_);

    /*  ===============
     *  Device is MRAID
     *  =============== */
    _["mr"] = (is_mraid)?1:-1;


    /*  =====================================
     *  Set a timeout incase browser hangs up
     *  ===================================== */
    var as_timeout = setTimeout(function(){
        var event = document.createEvent('Event');
        event.initEvent('ASLoaded', true, true);
        document.dispatchEvent(event);
    },500);



    /*  ===============================
     *  Function for Impression Capping
     *  =============================== */

    _["dur"] = Math.floor(Date.now()) - as_start;

    var _p = "?";

    for (var k in _)
    {
        _p += k + "=" + _[k] + "&";
    }

    var as_tag = document.createElement("script");

    document.getElementById("as-ad-tag").appendChild(as_tag);

    as_tag.src=$[21] + _p.replace(/&+$/, "");

    $[0].$as = $; $[0].$as_data = _;

    var event = document.createEvent('Event');
    event.initEvent('ASLoaded', true, true);
    document.dispatchEvent(event);

})());