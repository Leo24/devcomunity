jQuery(document).ready(function($){
    "use strict";
    $('.confirm-button').on('click', function(){
        $('.group-overlay').css('display', 'none');
        $('.popup-holder').css('display', 'none');
    });
    $('.back-button').on('click', function(){
        $('.group-overlay').css('display', 'none');
        $('.popup-holder').css('display', 'none');
    });
});
