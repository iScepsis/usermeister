var UserProto = {
    id: '',
    name: '',
    age: '',
    city_id: '',
    _row: null,
    /**
     * Валидируем свойства объекта
     * @returns {boolean}
     */
    validate: function () {
        var flag = true;
        if (!/^[А-ЯЁ][А-ЯЁa-яё\s-]{2,30}$/.test(this.name)) {
            $(this._row).find('.user-name').addClass('invalid');
            alert('Введенное имя не корректно. Имя должно начинаться с большой буквы и может содержать только русские' +
                'символы, знаки дефиса и пробелы');
            flag = false;
        }

        if (!/^\d{1,3}$/.test(this.age) || this.age < 0 || this.age > 120) {
            $(this._row).find('.user-age').addClass('invalid');
            alert('Возраст должен быть числом от 1 до 120');
            flag = false;
        }
        if (flag) {
            $(this._row).find('.invalid').removeClass('invalid');
        }
        return flag;
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
                    if (data['result'] == 'true') {
                        if (data['lastInsertId'] !== null) {
                            var new_row = $('.new-row');
                            new_row.find('.user-id').text(data['lastInsertId']);
                            new_row.removeClass('new-row');
                        }
                    }
                }
            });
        }
    }
}

function User(row, id, name, age, city_id){
    this.id = $.trim(id) || null;
    this.name = $.trim(name);
    this.age = $.trim(age);
    this.city_id = $.trim(city_id) || null;
    this._row = row;
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
        $(obj).html('<input type="text" maxlength="30" value="' + val + '">');
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
        $(obj).html(citiesSelect);
        $(obj).find('select option[value="'+val+'"]').prop('selected', true);
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
    saveRow(tr);
}

function expandCitySelect(obj){
    var text = $(obj).find(':selected').text(),
        val = $(obj).find(':selected').val(),
        tr = $(obj).closest('.user-row'),
        td = $(obj).closest('td');

    td.html(text);
    td.data('city_id', val);
    saveRow(tr);
}

function saveRow(row){
    var id = row.find('.user-id').text(),
        name = row.find('.user-name').text(),
        age = row.find('.user-age').text(),
        city_id = row.find('.user-city').data('city_id');

    var user = new User(row, id, name, age, city_id);
    user.save();
}

/**
 * ******************  DOCUMENT READY ******************
 */
$(document).ready(function(){

    var wrap = $('.user-wrap'),
        tbody = wrap.find('.users-table > tbody');

    //Создаем шаблон выпадающего списка с городами
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
    /**
     * Оборачиваем содержимое ячейки в select с выборкой города
     */
    $(document).on('click', '.i-city-select', function(){
        if ($('.cities-select').length > 0) {
            $('.cities-select').each(function(i,e){
                expandCitySelect(e);
            });
        }
        wrapUpCitySelect(this);
    });

    /**
     * Обрабатываем события потери фокуса и нажатия клавиши Enter в input элементе
     */
    $(document).on('blur', '.i-input > input', function(){
        expandInput(this);
    });
    $(document).on('keyup', '.i-input > input', function(e){
        if(e.keyCode == 13) $(this).blur();
    });

    /**
     * Обрабатываем события потери фокуса и нажатия клавиши Enter в select элементе
     */
    $(document).on('blur', '.i-city-select > select', function(){
        expandCitySelect(this);
    });
    $(document).on('change', '.i-city-select > select', function(e){
        $(this).blur();
    });

});