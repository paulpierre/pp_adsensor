
/** ------------------------------------------
 *  {AS_CAMPAIGN_NAME} {AS_BANNER_WIDTH}x{AS_BANNER_HEIGHT} Banner
 *  ------------------------------------------
 *  Supports both MRAID and Rich Media HTML5 formats
 */

var  is_mraid = typeof mraid !== 'undefined';
dd_mraid = document.createElement("script");
dd_mraid.src = "http://{AS_ROOT_DOMAIN}/sdk/pt/impression_tracker.sdk-v1-mraid.js";
document.getElementsByTagName('head')[0].appendChild(dd_mraid);
var dd_img_root = "{AS_IMG_ROOT}", //the root directory of the CDN images
    dd_images = [		//meta data for the image resources and animations
        {"i":"cta_1.png","d":200,"c":"bounceInDown"},
        {"i":"cta_2.png","d":700,"c":"rubberband"},
        {"i":"logo.png","d":1000,"c":"fadeInRightBig"},
        {"i":"btn_play.png","d":1500,"c":"shake infinite"},
        {AS_CM_IMAGES}],
    i = 0, dd_state=0, dd_rm, dd_logo, container, dd_class, db_b = "bounce",
    dd_click_url = "{AS_BANNER_CLICK_URL}";


function dd_load() //loads the initial animation
{


    container = document.getElementById("ad-container");
    dd_class = document.getElementsByClassName("dd_img");

    for(var i = 0; i< dd_images.length-2;i++)
        dd_animate(dd_class.item(i),dd_images[i+2]["i"],dd_images[i+2]["c"],dd_images[i+2]["d"]);

    dd_animate_finish(db_b);

}

function dd_animate_finish(i)
{
    dd_rm = document.getElementsByClassName(i);
    while(dd_rm[0]) dd_rm[0].parentNode.removeChild(dd_rm[0]); //free up the dom for the next set of animations

}

//basic function to do the work on the relevant animated images
function dd_animate(instance,dd_image,dd_css,d)
{
    if ((!window.$asqc && !d) || !instance || (!dd_state && !d)) return; //skip animation for invalid resources
    instance.src = dd_img_root + dd_image; //load the proper image resource
    var  class_name = instance.className;
    instance.className = class_name + " animated " +(!d?"dd_expand ":"")  + dd_css; //apply the appropriate css animation class
}


//interactive function
function dd_click()
{
    if(is_mraid) mraid.open(dd_click_url);  //if so, launch the click url when the user taps
    else window.top.location.href = dd_click_url;
}

//function called when mraid.js is loaded. it removes the eventListener and begins the rich media animation
function dd_mraid_ready()
{
    mraid.removeEventListener("ready", dd_mraid_ready);
    dd_load();
}



function dd_richmedia_ready()
{

    window.readyHandlers = [];
    window.ready = function ready(handler) {
        window.readyHandlers.push(handler);
        handleState();
    };

    window.handleState = function handleState () {
        if (["interactive", "complete"].indexOf(document.readyState) > -1) {
            while(window.readyHandlers.length > 0) {
                (window.readyHandlers.shift())();
            }
        }
    };

    document.onreadystatechange = window.handleState;
    ready(function(){
        dd_load();
    });
}

//if mraid.js is available, and it is still loading, add an event listener for when the SDK does load,
//and when it finally loads, remove the event listener start the animation. if mraid.js is not available,
//load the animation and assume this is a Rich Media HTML5 banner
if(!is_mraid) dd_richmedia_ready();
else if (is_mraid && mraid.getState() == "loading")
    mraid.addEventListener("ready", dd_mraid_ready);
else dd_load();
