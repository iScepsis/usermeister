function City(row, id, city) {
    this.id = $.trim(id) || null;
    this.city = $.trim(city);
    this._row = row;
    this._clientValidation = true,
    /**
     * Валидируем свойства объекта
     * @returns {boolean}
     */
        this.validate = function () {
            var flag = true;
            if (!/^[А-ЯЁ][А-ЯЁa-яё\s-]{2,29}$/.test(this.city)) {
                this.markAsInvalid('city');
                flag = false;
            }
            if (flag) {
                this.unmarkInvalids()
            }
            return flag;
        },
    /**
     * Сохранение изменений
     */
        this.save = function () {
            if (this._clientValidation && !this.validate()) return false;
            var that = this;
            $.ajax({
                url: 'index.php/cities/save',
                type: "POST",
                data: {
                    id: this.id,
                    city: this.city,
                },
                dataType: 'json',
                success: function (data) {
                    if (data['result'] == 'true') {
                        if (data['lastInsertId'] !== null) {
                            $(that._row).find('.city-id').text(data['lastInsertId']);
                            $(that._row).removeClass('new-row');
                            that.unmarkInvalids();
                        }
                    } else if (data['result'] == 'false') {
                        if (Object.keys(data['errors']['validation']).length > 0) {
                            var e = data['errors']['validation'];
                            for (var i in e) {
                                that.markAsInvalid(i, e[i]['invalidMessage']);
                            }
                        }
                    }
                }
            });

        },
        this.markAsInvalid = function (field, message) {
            $(this._row).find('.city-' + field).addClass('invalid');
            message = message || this.invalidMessages[field];
            alert(message);
        },
        this.unmarkInvalids = function () {
            $(this._row).find('.invalid').removeClass('invalid');
        },
        this.invalidMessages = {
            city: 'Название города не корректно. Название должно начинаться с большой буквы и может содержать ' +
            'только русские символы, знаки дефиса и пробелы'
        }
}

/**
 * Оборачиваем содержимое ячейки в input
 * @param obj
 */
function wrapUpInput(obj) {
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
 * Убираем из ячейки input и возвращаем обычный текст
 * @param obj
 */
function expandInput(obj) {
    var val = $(obj).val(),
        tr = $(obj).closest('.city-row');

    $(obj).parent().html(val);
    saveRow(tr);
}

function saveRow(row) {
    var id = row.find('.city-id').text(),
        i_city = row.find('.city-city').text();

    var city = new City(row, id, i_city);
    city.save();
}

/**
 * ******************  DOCUMENT READY ******************
 */
$(document).ready(function () {

    var wrap = $('.city-wrap'),
        tbody = wrap.find('.city-table > tbody');

    /**
     * Добавляем строку в таблицу с пользователями для создания нового пользователя
     */
    $('.add-city').on('click', function () {
        tbody.append(
            '<tr class="city-row new-row">' +
            '<td class="city-id"></td>' +
            '<td class="city-city i-input">Город</td>' +
            '</tr>'
        );
    });

    /**
     * Оборачиваем содержимое ячейки таблицы в input
     */
    $(document).on('click', '.i-input', function () {
        wrapUpInput(this);
    });

    /**
     * Обрабатываем события потери фокуса и нажатия клавиши Enter в input элементе
     */
    $(document).on('blur', '.i-input > input', function () {
        expandInput(this);
    });
    $(document).on('keypress', '.i-input > input', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $(this).blur();
        }
    });

});