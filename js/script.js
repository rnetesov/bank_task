function addAlert(text) {
    let content = `<div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Ошибка!</strong> ${text}
                </div>`;
    $(".calculator").prepend(content);
}

function clearAlerts() {
    let alert = $(".calculator").find('div.alert');
    if (alert.length) alert.each(function () {
        $(this).remove();
    })
}

function validateCalcData(summ, summAdd, choise, time, date) {
    let summVal = +summ.val().replace(/\s+/g, '');
    let summAddVal = +summAdd.val().replace(/\s+/g, '');
    let timeVal = time.val();
    let choiseVal = choise.val();
    let dateVal = date.val();

    let isValid = true;

    if (dateVal.length === 0) {
        addAlert("Пожалуйста укажите дату оформления вклада!");
        date.addClass('error');
        isValid = false;
    }

    if (!choiseVal.includes("yes") && !choiseVal.includes("no")) {
        addAlert("Галочка пополнение вклада имеет некорректный формат!");
        isValid = false;
    }

    if (isNaN(timeVal) || timeVal > 5) {
        addAlert("Поле срок вклада имеет некорректный формат!");
        time.addClass('error');
        isValid = false;
    }

    if (isNaN(summVal)) {
        addAlert("Сумма может содержать только число!");
        summ.addClass('error');
        isValid = false;
    }

    if (summVal <= 0) {
        addAlert("Сумма может быть только положительным числом")
        summ.addClass('error');
        isValid = false;
    }

    if (summVal > 3000000 || summVal < 1000) {
        addAlert("Сумма вклада может быть от 1000 до 3 000 000 руб.");
        summ.addClass('error');
        isValid = false;
    }

    if (choise.val() === "yes") {
        if (isNaN(summAddVal)) {
            addAlert("Сумма пополнения вклада может быть только числом");
            summAdd.addClass('error');
            isValid = false;
        }

        if (summAddVal <= 0) {
            addAlert("Сумма пополнения вклада быть только положительным числом")
            summAdd.addClass('error');
            isValid = false;
        }

        if (summAddVal > 3000000 || summAddVal < 1000) {
            addAlert("Сумма пополнения вклада может быть от 1000 до 3 000 000 руб.");
            summAdd.addClass('error');
            isValid = false;
        }
    }

    return isValid;
}

function addResultBlock(text) {
    $("span.result").html("<b>Результат : </b> " + text + " руб.");
}

function clearResultBlock() {
    $("span.result").html("");
}

function clearErrors(summ, summAdd, time, date) {
    summ.removeClass('error');
    summAdd.removeClass('error');
    time.removeClass('error');
    date.removeClass('error');
}

function numberFormat(number, thousandSeparator = ' ') {
    return String(number).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1' + thousandSeparator);
}

$(function () {
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $("#slider1").slider({
        animate: "slow",
        range: "min",
        min: 1000,
        max: 3000000,
        slide: function (event, ui) {
            $("#summ").val(numberFormat(ui.value));
        }
    });

    $("#slider2").slider({
        range: "min",
        min: 1000,
        max: 3000000,
        animate: true,
        slide: function (event, ui) {
            $("#summ_add").val(numberFormat(ui.value));
        }
    });

    $("#summ").val($("#slider1").slider("value"));

    $("#calculator").submit(function (evt) {
        evt.preventDefault();

        let date = $(this).find("input[name=date]");
        let summ = $(this).find("input[name=summ]");
        let summAdd = $(this).find("input[name=summadd]");
        let time = $(this).find("select[name=time]");
        let choiseAdd = $(this).find("input:checked");

        clearAlerts();
        clearResultBlock();
        clearErrors(summ, summAdd, time, date);

        if (validateCalcData(summ, summAdd, choiseAdd, time, date)) {
            let data = {
                date: date.val(),
                summ: summ.val().replace(/\s/g, ''),
                summadd: summAdd.val().replace(/\s/g, ''),
                time: time.val(),
                selection: choiseAdd.val(),
            }

            $.ajax({
                type: "POST",
                url: "/calc.php",
                data: data,
                success: function (data) {
                    let result = JSON.parse(data);
                    if (result.type === 'ok') {
                        addResultBlock(result.content);
                    }
                },
            });
        }

    })

});