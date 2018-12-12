$(document).ready(function(){
    $('.show-hide-nav').on('click', function(){
        var main = $('#main-body-container');
        var nav = $('#sidebar-container');

        if(main.hasClass('leftPadding')){
            nav.hide();
        }else{
            nav.show()
        }

        main.toggleClass('leftPadding');
    })
})