<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>World Bank</title>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/external/jquery/jquery.js"></script>
    <script src="js/jquery-ui.min.js"></script>

</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <a href="#">
                <img src="img/logo.png" alt="">
            </a>
        </div>
        <div class="phones">
            <span>8-800-100-5005</span>
            <br>
            <span>+7 (3452) 522-000</span>
        </div>
    </header>

    <nav class="top-nav">
        <ul>
            <li><a href="#">Кредитные карты</a></li>
            <li><a href="#" class="active">Вклады</a></li>
            <li><a href="#">Дебитовые карты</a></li>
            <li><a href="#">Страхование</a></li>
            <li><a href="#">Друзья</a></li>
            <li><a href="#">Интернет-банк</a></li>
        </ul>
    </nav>

    <div class="content">
        <ul class="breadcrumb">
            <li><a href="#">Главная</a></li>
            <li><a href="#">Вклады</a></li>
            <li>Калькулятор</li>
        </ul>
        
        <div class="calculator">
            
            <h1>Калькулятор</h1>
            
            <form action="/calc.php" method="post" id="calculator">
                <div class="row">
                    <div class="col-1">
                        <label for="datepicker">Дата оформления вклада</label>
                    </div>
                    <div class="col-2">
                        <input type="text" id="datepicker" name="date" placeholder="дд.мм.гг">
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label for="summ">Сумма вклада</label>
                    </div>
                    <div class="col-2">
                        <input type="text" id="summ" name="summ">
                        <div id="slider1" class="range">
                            <p class="min">1 тыс. руб.</p>
                            <p class="max">3 000 000</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label for="time">Срок вклада</label>
                    </div>
                    <div class="col-2">
                        <select id="time" name="time">
                            <option value="1">1 год</option>
                            <option value="2">2 года</option>
                            <option value="3">3 года</option>
                            <option value="4">4 года</option>
                            <option value="5">5 лет</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Пополение вклада</label>
                    </div>
                    <div class="col-2 add">
                        <p>
                            <input type="radio" id="no" name="selection" value="no" checked>
                            <label for="no">Нет</label>
                        </p>
                        <p>
                            <input type="radio" id="yes" name="selection" value="yes">
                            <label for="yes">Да</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label for="summ_add">Сумма пополение вклада</label>
                    </div>
                    <div class="col-2">
                        <input type="text" id="summ_add" name="summadd" value="1000">
                        <div id="slider2" class="range">
                            <p class="min">1 тыс. руб.</p>
                            <p class="max">3 000 000</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" value="Рассчитать">
                    <span class="result"></span>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <nav class="bottom-nav">
            <ul>
                <li><a href="#">Кредитные карты</a></li>
                <li><a href="#">Вклады</a></li>
                <li><a href="#" class="active">Дебитовые карты</a></li>
                <li><a href="#">Страхование</a></li>
                <li><a href="#">Друзья</a></li>
                <li><a href="#">Интернет-банк</a></li>
            </ul>
        </nav>
    </footer>
</div>

<script src="js/script.js"></script>

</body>
</html>