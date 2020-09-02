$(function() {
    $('#tabselector').change(function(){
        $('.tab').hide();
        $('#' + $(this).val()).show();
    });
});
