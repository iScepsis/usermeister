$(document).ready(function () {

});

/**
 * Размещаем курсор в конец строки
 */
(function($){
    $.fn.setCursorToTextEnd = function() {
        var initialVal = this.val();
        this.val('').val(initialVal);
    };
})(jQuery);