
/** ------------------------------------------
 *  {AS_CAMPAIGN_NAME} {AS_BANNER_WIDTH}x{AS_BANNER_HEIGHT} Banner
 *  ------------------------------------------
 *  Supports both MRAID and Rich Media HTML5 formats
 */

    //Define and include MRAID.js
dd_mraid = document.createElement("script");
dd_mraid.source = "mraid.js"; //TODO: MUST INSERT INTO DOC FIRST!!!


var dd_img_root = "{AS_IMG_ROOT}", //the root directory of the CDN images
    dd_images = [		//meta data for the image resources and animations
        {"i":"cta_1.png","d":200,"c":"bounceInDown"},
        {"i":"cta_2.png","d":700,"c":"rubberband"},
        {"i":"logo.png","d":1000,"c":"fadeInRightBig"},
        {"i":"btn_play.png","d":1500,"c":"shake infinite"},
        {AS_CM_IMAGES}],
    i = 0, dd_player, dd_image, dd_state=1, did_close,dd_cta1, dd_cta2, dd_rm,dd_close, dd_video, dd_logo, dd_video_tag, dd_video_script, container, dd_class, db_b = "bounce",
    dd_click_url = "{AS_BANNER_CLICK_URL}",
    dd_video_url = "{AS_BANNER_VIDEO_URL}";

function dd_load() //loads the initial animation
{


    container = document.getElementById("ad-container");
    dd_class = document.getElementsByClassName("dd_img");

    for(var i = 0; i< dd_images.length-2;i++)
        dd_animate(dd_class.item(i),dd_images[i+2]["i"],dd_images[i+2]["c"],dd_images[i+2]["d"]);

    dd_animate_finish(db_b);

    {AS_JS_REDIRECT}

}

//load all the images in the DOM
function dd_start_animation()
{
    //return;
    i = 0;

    //iterate through all the images in the MRAID creative
    for (var k in dd_images)
    {
        var dd_image = dd_images[k]["i"],				//image resource
            dd_animation_delay = dd_images[k]["d"], 	//animation duration
            dd_css = dd_images[k]["c"]; 							//the image class
        //pass the local instance variables to another function to apply the CSS animations
        setTimeout(dd_animate(dd_class.item(i),dd_image,dd_css,dd_animation_delay),dd_animation_delay);
        i++;
    }
    dd_animate_finish(db_b); //let's clean up the resources after animation
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

function dd_reset_animation()
{
    container.className = "container-min";
    dd_animate_finish("dd_expand");
}



//interactive function
function dd_expand()
{if(did_close) { did_close = 0; return;}

   //dd_state keeps track of whether it is the first or second tap.
    if(dd_state == 0) {	//if dd_state has a value > 0, we can assume it is the second tap
        dd_state = -1;
        dd_reset_animation();
        if(is_mraid) mraid.open(dd_click_url);  //if so, launch the click url when the user taps
        else window.top.location.href = dd_click_url;
      return;

    }
    container.className = "container-max"; //in this case lets setup the elements within the expanded banner
    dd_cta1 = document.createElement("img");
    dd_cta1.id = "dd-cta-1";
    dd_cta1.className = "dd_img dd_expand";

    dd_cta2 = document.createElement("img");
    dd_cta2.id = "dd-cta-2";
    dd_cta2.className = "dd_img dd_expand";

    dd_video = document.createElement("video");
    dd_video.className = "dd_expand";
    dd_video.width = 320;
    dd_video.height = 215;
    dd_video.id = "dd-video";
    dd_video.setAttribute("webkit-playsinline","");
    dd_video.type="video/mp4";
    dd_video.poster=dd_img_root + "img_poster.png";
    dd_video.src=dd_video_url; //trailer video URL


    dd_logo = document.getElementById("dd-logo");

    //lets add a close button
    dd_close = document.createElement("div");
    dd_close.id = "dd-close";
    dd_close.className = "dd_expand";


    //insert them into the dom so they are nice and lined up
    container.insertBefore(dd_cta1,dd_logo);
    container.insertBefore(dd_cta2,dd_logo);
    container.insertBefore(dd_video,dd_logo);
    container.appendChild(dd_close);

    dd_close.addEventListener("click",function(e){
        e.preventDefault();
        dd_reset_animation();
        did_close = 1;
        if(is_mraid) mraid.close();

    });


    dd_video.load();
    dd_video.play();

    if(dd_state) dd_state = 0; //if this is not set, it means it is the first tap

    dd_start_animation();

    if(is_mraid) mraid.expand(); //after we setup the elements, lets expand the banner

}

//function called when mraid.js is loaded. it removes the eventListener and begins the rich media animation
function dd_mraid_ready()
{
    mraid.removeEventListener("ready", dd_mraid_ready);
    dd_load();
}



function dd_richmedia_ready(dd_function)
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
