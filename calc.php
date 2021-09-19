<?php

session_start();

function getInvestmentTermInMonths(string $depositOpeningDay, int $years): int
{
	$start = new DateTime($depositOpeningDay);
	$end = (clone $start)->add(new DateInterval('P' . $years . 'Y'));
	$interval = $start->diff($end);
	return $interval->m + 12 * $interval->y;
}

function calcDepositWithoutAddInvest($summ, $percent, $time)
{
	$months = $time * 12;
	return $summ * pow((1 + $percent / 100 / 12), $months);
}

function calcDepositWithAddInvest($summ, $summAdd, $percent, $date, $time)
{
	$months = getInvestmentTermInMonths($date, $time);
	
	for ($i = 0; $i < $months; $i++) {
		$total = $summ * (1 + $percent / 100 / 12);
		$summ = $total;
		$summ += $summAdd;
	}
	
	return $total;
}

function validateData($date, $summ, $timeInYears, $selection, $summAdd)
{
	$errors = [];
	
	if (!strtotime($date)) $errors[] = "Поле дата имееет некорректный формат";
	
	if (empty($summ)) $errors[] = "Вы не заполнини поле сумма!";
	
	if (empty($timeInYears)) $errors[] = "Вы не заполинили поле срок!";
	
	if (strpos($selection, "yes") === false && strpos($selection, "no") === false) {
		$errors[] = "Возможно только да или нет для поля пополнить вклад";
	}
	
	if ($selection == 'yes') {
		if (empty($summAdd)) $errors[] = "Поле сумма пополнения вклада не может быть пустой!";
		if (!is_numeric($summAdd)) $errors[] = "Поле сумма пополнения вклада может быль только числом";
	}
	
	if (!is_numeric($summ)) $errors[] = "Поле сумма может быть только числом";
	
	if (!is_numeric($timeInYears) || $timeInYears > 5) $errors[] = "Некорректные данные для поля срок вклада";
	
	return $errors;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$date = trim($_POST['date']) ?: date("d-m-Y", time());
	$summ = trim($_POST['summ']);
	$timeInYears = trim($_POST['time']);
	$selection = strtolower(trim($_POST['selection']));
	$summ_add = trim($_POST['summadd']);
	$percent = 10.0;
	
	$errors = validateData($date, $summ, $timeInYears, $selection, $summ_add);
	$deposit_amount = 0.0;
	
	if (empty($errors)) {
		switch ($selection) {
			case 'no':
				$deposit_amount = calcDepositWithoutAddInvest($summ, $percent, $timeInYears);
				break;
			case 'yes' :
				$deposit_amount = calcDepositWithAddInvest($summ, $summ_add, $percent, $date, $timeInYears);
				break;
		}
		
		$result = number_format($deposit_amount, 0, ',', ' ');
		
		echo json_encode([
			'type' => 'ok',
			'content' => $result,
		]);
	} else {
		echo json_encode([
			'type' => 'error',
			'content' => $errors
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
}
