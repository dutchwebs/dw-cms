$( document ).ready(function() {

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function(){ 
        $('.navbar-toggle:visible').click();
    });
    
    //Background video support
var isMobile = /iPad|iPhone|iPod|Android|webOS|BlackBerry|Windows Phone/.test(navigator.platform);
if (isMobile) {

    // Use canvas fallback video

    var canvasVideo = [];
    var counter = 1;

    $('.fullscreen-bg-video-canvas').each(function( index ) {

        try {

            $(this).parent().find('.fullscreen-bg-video-canvas').attr("id", "fullscreen-bg-video-canvas-" + counter);
            $(this).parent().find('.fullscreen-bg-video').attr("id", "fullscreen-bg-video-" + counter);

            canvasVideo[counter] = new CanvasVideoPlayer({
                videoSelector: "#fullscreen-bg-video-" + counter,
                canvasSelector: "#fullscreen-bg-video-canvas-" + counter,
                timelineSelector: false,
                autoplay: true,
                makeLoop: true,
                pauseOnClick: false,
                audio: false
            });

        }catch(e) {
            console.log("Background video doesn't work: " + e.message);
        }

        counter++;
    });

    $("header").each(function() {
        $(this).css("background-attachment", "scroll");
    });
    $("section").each(function() {
        $(this).css("background-attachment", "scroll");
    });
    $("aside").each(function() {
        $(this).css("background-attachment", "scroll");
    });

}else {

    // Use HTML5 video
    $('.canvas').each(function( index ) {
        $(this).hide();
    });
    
    window.addEventListener( 'scroll', function( event ) {
        var scrollHeight = $(document).scrollTop();
        if(scrollHeight > 50) {
            $("#mainNav").attr("class", "navbar navbar-default navbar-custom navbar-fixed-top affix");
        }else {
            $("#mainNav").attr("class", "navbar navbar-default navbar-custom navbar-fixed-top affix-top");
        }
    }, false );

}

});