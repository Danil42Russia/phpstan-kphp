<?php

declare(strict_types = 1);

use function PHPStan\Testing\assertType;

{
  /** @var bool $type */
  $type = false;
  $type = not_false($type);

  assertType("bool", $type);
}

{
  /** @var string|bool $type */
  $type = false;
  $type = not_false($type);

  assertType("bool|string", $type);
}

{
  /** @var string|false $type */
  $type = false;
  $type = not_false($type);

  assertType("string", $type);
}

{
  /** @var int|false $type */
  $type = false;
  $type = not_false($type);

  assertType("int", $type);
}

{
  /** @var mixed $type */
  $type = false;
  $type = not_false($type);

  assertType("mixed", $type);
}

{
  /** @var int|false|null|string $type */
  $type = false;
  $type = not_false($type);

  assertType("int|string|null", $type);
}

{
  class Clazz {
  }

  /** @var Clazz|false $type */
  $type = false;
  $type = not_false($type);

  assertType(Clazz::class, $type);
}

