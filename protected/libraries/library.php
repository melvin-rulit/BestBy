<?php
/**
 * Библиотека Методов-Хелперов
 */
function __autoload($class_name)
{
	$filename = $class_name . '.php';

	if (!include($filename)) {
		return false;
	}
}

function var_info($vars, $d = false)
{
	echo "<pre class='alert alert-info'>\n";
	var_dump($vars);
	echo "</pre>\n";
	if ($d) {
		exit();
	}
}

function genPassword($size = 8)
{
	$a = ['e', 'y', 'u', 'i', 'o', 'a'];
	$b = ['q', 'w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
	$c = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
	$e = ['-'];
	$password = $b[array_rand($b)];
	do {
		$lastChar = $password[strlen($password) - 1];
		@$predLastChar = $password[strlen($password) - 2];
		if (in_array($lastChar, $b)) {//последняя буква была согласной
			if (in_array($predLastChar, $a)) {//две последние буквы были согласными
				$r = rand(0, 2);
				if ($r) {
					$password .= $a[array_rand($a)];
				} else {
					$password .= $b[array_rand($b)];
				}
			} else {
				$password .= $a[array_rand($a)];
			}
		} elseif (!in_array($lastChar, $c) && !in_array($lastChar, $e)) {
			$r = rand(0, 2);
			if ($r == 2) {
				$password .= $b[array_rand($b)];
			} elseif ($r == 1) {
				$password .= $e[array_rand($e)];
			} else {
				$password .= $c[array_rand($c)];
			}
		} else {
			$password .= $b[array_rand($b)];
		}
	} while (($len = strlen($password)) < $size);
	return $password;
}

function checkAuthAdmin()
{
	if (isset($_SESSION['admin'])) {
		if ($_SESSION['admin']['agent'] != $_SERVER['HTTP_USER_AGENT']) {
			$error = 1;
		}
		if ($_SESSION['admin']['ip'] != $_SERVER['REMOTE_ADDR']) {
			$error = 1;
		}
	}
	if (isset($error)) {
		unset($_SESSION['admin']);
	}
	if (!isset($_SESSION['admin'])) {
		return false;
	}
	return true;
}

/**
 * Проверка на суперадмина
 */
function isSuperAdmin()
{
    if ((int)$_SESSION['admin']['type'] === 1) {
        return true;
    }
    return false;
}

function dumpAdmin($var)
{
    if (isSuperAdmin()) {
        Dumphper::dump($var);
    }
    return false;
}

function dd($var)
{
    die(Dumphper::dump($var));
}

/**
 * @param array $array
 * @param       $key - ключ текущего массива
 * @return bool
 * Проверяем является ли переданный элемент, последним по нумерации в массиве
 */
function isLast($array = [], $key): bool
{
    $last_key = key(array_slice($array, -1, 1, true));
    if ($last_key === $key) {
        return true;
    }
    return false;
}

/**
 * @param $str
 * @param $type
 * @param $tag
 * @return string
 * Возвращает обернутое сообщение
 */
function alertMessage($str, $type = 3, $tag = 'div'): string
{
    if ($type == 0) {
        $type = 'danger';
    }
    if ($type == 1) {
        $type = 'success';
    }
    if ($type == 2) {
        $type = 'warning';
    }
    if ($type == 3) {
        $type = 'info';
    }
    return '<' . $tag . ' class="alert alert-' . $type . '">' . $str . '</' . $tag . '>';
}

function parseDateFromReview($date)
{
    $str_pos = strpos($date, " ");
    $result = substr($date, 0, $str_pos);
    $converter = array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентбря',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря'
    );
    $tmp_arr = explode('-', $result);
    $tmp_arr['1'] = strtr($tmp_arr['1'], $converter);
    $result = $tmp_arr['2'] . '-' . $tmp_arr['1'] . '-' . $tmp_arr['0'];
    $time_rev = substr($date, $str_pos, strlen($date));
    $time_rev = explode(':', $time_rev);
    $time_rev = $time_rev[0] . ':' . $time_rev[1];

    $time_old = '';

    $time_passed = new DateTime($date);
    $time_passed = $time_passed->diff(new DateTime(date('Y-m-d H:i:s')));
    $tpa['y'] = $time_passed->format("%y");
    $tpa['m'] = $time_passed->format("%m");
    $tpa['d'] = $time_passed->format("%d");
    $tpa['h'] = $time_passed->format("%h");
    $tpa['i'] = $time_passed->format("%i");
    $tpa['s'] = $time_passed->format("%s");

    if ($tpa['y'] < 1) {
        if ($tpa['m'] < 1) {
            if ($tpa['d'] < 1) {
                if ($tpa['h'] < 1) {
                    if ($tpa['i'] < 1) {
                        $time_old .= $tpa['s'];
                        if (substr($tpa['s'], -1) == 1 && $tpa['s'] != 11) {
                            $time_old .= " секунда";
                        } elseif (substr($tpa['s'], -1) > 1 && substr($tpa['s'],
                                -1) < 5 && ($tpa['s'] > 20 || $tpa['s'] < 10)) {
                            $time_old .= " секунды";
                        } else {
                            $time_old .= " секунд";
                        }
                    } else {
                        $time_old .= $tpa['i'];
                        if (substr($tpa['i'], -1) == 1 && $tpa['i'] != 11) {
                            $time_old .= " минута";
                        } elseif (substr($tpa['i'], -1) > 1 && substr($tpa['i'],
                                -1) < 5 && ($tpa['i'] > 20 || $tpa['i'] < 10)) {
                            $time_old .= " минуты";
                        } else {
                            $time_old .= " минут";
                        }
                    }
                } else {
                    $time_old .= $tpa['h'];
                    if (substr($tpa['h'], -1) == 1 && $tpa['h'] != 11) {
                        $time_old .= " час";
                    } elseif (substr($tpa['h'], -1) > 1 && substr($tpa['h'],
                            -1) < 5 && ($tpa['h'] > 20 || $tpa['h'] < 10)) {
                        $time_old .= " часа";
                    } else {
                        $time_old .= " часов";
                    }
                }
            } else {
                $time_old .= $tpa['d'];
                if (substr($tpa['d'], -1) == 1 && $tpa['d'] != 11) {
                    $time_old .= " день";
                } elseif (substr($tpa['d'], -1) > 1 && substr($tpa['d'],
                        -1) < 5 && ($tpa['d'] > 20 || $tpa['d'] < 10)) {
                    $time_old .= " дня";
                } else {
                    $time_old .= " дней";
                }
            }
        } else {
            $time_old .= $tpa['m'];
            if (substr($tpa['m'], -1) == 1 && $tpa['m'] != 11) {
                $time_old .= " месяц";
            } elseif (substr($tpa['m'], -1) > 1 && substr($tpa['m'], -1) < 5 && ($tpa['m'] > 20 || $tpa['m'] < 10)) {
                $time_old .= " месяца";
            } else {
                $time_old .= " месяцев";
            }
        }
    } else {
        $time_old .= $tpa['y'];
        if (substr($tpa['y'], -1) == 1 && $tpa['y'] != 11) {
            $time_old .= " год";
        } elseif (substr($tpa['y'], -1) > 1 && substr($tpa['y'], -1) < 5 && ($tpa['y'] > 20 || $tpa['y'] < 10)) {
            $time_old .= " года";
        } else {
            $time_old .= " лет";
        }
    }

    return [
        'time' => $time_rev,
        'date' => $result . ' в ' . $time_rev,
        'time_old' => $time_old . ' назад',
    ];
}