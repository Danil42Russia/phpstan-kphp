<?php

declare(strict_types = 1);

use function PHPStan\Testing\assertType;

/** @var string|null $string */
$string = null;
if ($string === null) {
  $string = "";
}

$string = not_null($string);

assertType("string", $string);

/** @var int|null $int */
$int = null;
if ($int === null) {
  $int = 1;
}

$int = not_null($int);

assertType("int", $int);

/** @var mixed $mixed */
$mixed = null;
if ($mixed === null) {
  $mixed = "";
}

$mixed = not_null($mixed);

assertType("mixed", $mixed);

class Clazz {}

/** @var Clazz|null $clazz */
$clazz = null;
if ($clazz === null) {
  $clazz = new Clazz();
}

$clazz = not_null($clazz);

assertType(Clazz::class, $clazz);
