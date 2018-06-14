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

function urlHelper(route) {
    return window.location.pathname.replace(/[\w-]+\/[\w-]+\\*$/, route)
};