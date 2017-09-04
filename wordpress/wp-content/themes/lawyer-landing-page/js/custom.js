jQuery(document).ready( function($){
    
    // MeanMenu (responsive menu)
    $('header nav').meanmenu({
        meanScreenWidth: "991",
        meanRevealPosition: "center"
    });
    
    // The slider being synced must be initialized first
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 30,
        asNavFor: '#slider'
    });
    
    $('#slider').flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
    });
    
    
    /* Masonry for faq */
    if( $('.page-template-template-home').length > 0 ){
        $('.rara-masonry').imagesLoaded(function(){ 
            $('.rara-masonry').masonry({
                itemSelector: '.col'
            }); 
        });
        
    }

    // custom scrollbar
    $(".team .col .img-holder .text-holder").niceScroll({
        cursorcolor: "#000000",
        cursorborder: "0",
        cursorwidth: "3px"
    });
    
    $(".practice-area .box .text-holder").niceScroll();

    $(".why-us .box .text-holder").niceScroll();
});