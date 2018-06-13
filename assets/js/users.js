$(document).ready(function(){

    var wrap = $('.user-wrap'),
        tbody = wrap.find('.users-table > tbody');

    $('.add-user').on('click', function(){
        tbody.append('<tr><td></td><td>Имя</td><td>Возраст</td><td>Город не установлен</td></tr>');
    });

    $(document).on('click', '.i-input', function(){
        wrapUpInput(this);
    });

    $(document).on('blur', '.i-input > input', function(){
        expandInput(this);
    });

});

function wrapUpInput(obj){

    var input = $(obj).find('input');
    if (input.length > 0) {
        /*var val = input.val();
        $(obj).html(val);*/
    } else {
        var val = $(obj).text();
        $(obj).html('<input type="text" value="' + val + '">');
        var i = $(obj).find('input');
        $(i).focus();
        $(i).setCursorToTextEnd();
        //i.selectionStart = i.selectionEnd = i.val().length;
    }
}

function expandInput(obj){
    var val = $(obj).val();
    $(obj).parent().html(val);
}