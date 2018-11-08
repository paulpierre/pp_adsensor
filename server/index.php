<?php



date_default_timezone_set('America/Los_Angeles');

include_once('constants.php');

/** +--------------------------------+
 *  | Adsensor.io by paul@pixel6.net |
 *  +--------------------------------+
 *  a cloaking, anti-fraud, and payload delivery platform
 */

include_once('campaigns.php');

/** ================
 *  RESOURCE MAPPING
 *  ================
 */



header("Access-Control-Allow-Origin: *");
$available_domains = Array('www','cdn','track','api','dashboard');
$sub_domain = explode('.',$_SERVER['SERVER_NAME']);
$app_name = isset($sub_domain[0])? $sub_domain[0]:'www';

//if($app_name == 'cdn2' || $app_name == 'files') $app_name = 'cdn';
/** -------------------------------------
 *  In case we want to use alternative
 *  names for the subdomains to avoid TMT
 *  -------------------------------------
 */
switch($app_name)
{
    //Alternative for cdn.xxx.xxx
    case 's3': case 'cdn2': case 'files':
        $app_name = 'cdn';
    break;

    //Alternative for track.xxx.xxx
    case 'trk2': case 'trk':
        $app_name = 'track';
    break;
}


$app_path = $_SERVER['DOCUMENT_ROOT'] .'/' . $app_name . '/';
if(file_exists($app_path)) {
    chdir($app_path);
    include_once($app_path . 'index.php');
} else
    show_404();


function show_404()
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
    <h1>404</h1><br/>
    <h3>Not found</h3>
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-#########-1', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
EOF;
    exit($_html);
}

?>