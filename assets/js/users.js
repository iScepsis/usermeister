
var UserProto = {
    id: '',
    name: '',
    age: '',
    city_id: '',
    _invalid_field: null,
    _obj: null,
    /**
     * Валидируем свойства объекта
     * @returns {boolean}
     */
    validate: function () {
        if (!/^[a-я]{2,30}$/i.test(this.name)) {
            this._invalid_field = 'user-name';
            return false;
        }
        if (typeof this.age != 'number' && (this.age < 0 || this.age > 150)) {
            this._invalid_field = 'user-age';
            return false;
        }
        return true;
    },
    save: function(){
        if (this.validate()) {
            $.ajax({
                url: 'index.php/users/save',
                type: "POST",
                data: {
                    id: this.id,
                    name: this.name,
                    age: this.age,
                    city_id: this.city_id
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                }
            });
        } else {
            //TODO: подсветка невалидных полей
        }
    }
}

function User(id, name, age, city_id){
    this.id = id || null;
    this.name = $.trim(name);
    this.age = parseInt($.trim(age));
    this.city_id = city_id || null;
    this.__proto__ = UserProto
}


$(document).ready(function(){

    var wrap = $('.user-wrap'),
        tbody = wrap.find('.users-table > tbody');

    /**
     * Добавляем строку в таблицу с пользователями для создания нового пользователя
     */
    $('.add-user').on('click', function(){
        tbody.append(
            '<tr class="user-row new-row">' +
                '<td class="user-id"></td>' +
                '<td class="user-name i-input">Имя</td>' +
                '<td class="user-age i-input">Возраст</td>' +
                '<td class="user-city i-city-select" data-city_id="">Город не установлен</td>' +
            '</tr>'
        );
    });

    /**
     * Оборачиваем содержимое ячейки таблицы в input
     */
    $(document).on('click', '.i-input', function(){
        wrapUpInput(this);
    });

    /**
     * Обрабатываем события потери фокуса и нажатия клавиши Enter в таблице
     */
    $(document).on('blur', '.i-input > input', function(){
        expandInput(this);
    });
    $(document).on('keyup', '.i-input > input', function(e){
        if(e.keyCode == 13) expandInput(this);
    });



});

/**
 * Оборачиваем содержимое ячейки в input
 * @param obj
 */
function wrapUpInput(obj){
    var input = $(obj).find('input');
    if (input.length <= 0) {
        var val = $(obj).text();
        $(obj).html('<input type="text" value="' + val + '">');
        var i = $(obj).find('input');
        $(i).focus();
        $(i).setCursorToTextEnd();
    }
}

/**
 * Убираем из ячейки input и возвращаем обычный текст
 * @param obj
 */
function expandInput(obj){
    var val = $(obj).val();
    $(obj).parent().html(val);
}