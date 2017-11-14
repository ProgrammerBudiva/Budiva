function open_popup(box, width, height, yt) {
    if(!$(box + ' iframe').length && yt) {
        $(box).append('<iframe id="yt" width="100%" height="100%" src="../www.youtube.com/embed/' + yt + '_40rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
    }
    $(box + ' .popup-close').html('<div class="popup-l1"></div><div class="popup-l2"></div>');
    if(width) $(box).css({'width': width, 'margin-left': -(width / 2)});
    if(height) $(box).css({'height': height, /*'margin-top': -(height/2)*/});
    else $(box).css('margin-top', -($(box).height() / 2));
    $(box).show();
}
function close_popup(box) {
    $(box).hide();
    $(box + ' #yt').remove();
}


//Кликая по ссылке вызываем окно, которое затмит экран и по клику на него закроет видео
$(document).ready(function() {

    $('.youtube').click(function() {
        $("#close-head-nav-top").toggle(0);
    });

    $('.close-btn').click(function() {
        $("#close-head-nav-top").toggle(0);
    });
});

//


$(".youtube").click(function() {
    $("body").addClass("expand");
});


//

$(function() {
    $(".popup-close").on("click", function() {
        $("#close-head-nav-top").hide();
    })
});





