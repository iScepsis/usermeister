
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
        if (!/^[a-я\s-]{2,30}$/i.test(this.name)) {
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
            console.log(this._invalid_field);
            //TODO: подсветка невалидных полей
        }
    }
}

function User(obj, id, name, age, city_id){
    this.id = $.trim(id) || null;
    this.name = $.trim(name);
    this.age = parseInt($.trim(age));
    this.city_id = $.trim(city_id) || null;
    this._obj = obj;
    this.__proto__ = UserProto
}

var citiesSelect = null;

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
 * Добавляем содержимое ячейки в select
 * @param obj
 */
function wrapUpCitySelect(obj){
    var select = $(obj).find('select');
    if (select.length <= 0) {
        var val = $(obj).data('city_id');
        $(obj).html('<input type="text" value="' + val + '">');

    }
}

/**
 * Убираем из ячейки input и возвращаем обычный текст
 * @param obj
 */
function expandInput(obj){
    var val = $(obj).val(),
        tr = $(obj).closest('.user-row');

        $(obj).parent().html(val);

    var id = tr.find('.user-id').text(),
        name = tr.find('.user-name').text(),
        age = tr.find('.user-age').text(),
        city_id = tr.find('.city_id').data('city_id');

        console.log(id, name, age, city_id);

    var user = new User(tr, id, name, age, city_id);
        user.save();
}


$(document).ready(function(){

    var wrap = $('.user-wrap'),
        tbody = wrap.find('.users-table > tbody');

    if (Array.isArray(cities) !== undefined) {
        citiesSelect = '<select class="cities-select">';
        citiesSelect += '<option value="">Город не выбран</option>';
        for (var i in cities) {
            citiesSelect += '<option value="' + cities[i]['id'] + '">' + cities[i]['city'] + '</option>';
        }
        citiesSelect += '</select>';
    } else {
        console.warn("Не удалось получить список городов, либо список имеет некорректный формат");
    }


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

    $(document).on('click', '.i-city-select', function(){
        wrapUpCitySelect(this);
    });

    /**
     * Обрабатываем события потери фокуса и нажатия клавиши Enter в таблице
     */
    $(document).on('blur', '.i-input > input', function(){
        expandInput(this);
    });
    $(document).on('keyup', '.i-input > input', function(e){
        if(e.keyCode == 13) $(this).blur();
    });



});