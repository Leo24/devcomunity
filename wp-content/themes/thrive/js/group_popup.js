jQuery(document).ready(function($){
    "use strict";
    $('.confirm-button').on('click', function(){
        var data = {
            action: 'acceptGroupConditions',
            userId: $(this).data('userid'),
            groupId: $(this).data('groupid')
        };
        jQuery.post( ajax.url, data, function(response) {
            console.log(response.message);
        });
        $('.group-overlay').css('display', 'none');
        $('.popup-holder').css('display', 'none');
    });

    $('.back-button').on('click', function(){
        window.history.go(-1);
        return false;
    });
});
