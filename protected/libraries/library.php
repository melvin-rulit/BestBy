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