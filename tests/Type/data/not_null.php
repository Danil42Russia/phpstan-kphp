<?php

declare(strict_types = 1);

use function PHPStan\Testing\assertType;

{
  /** @var string|null $type */
  $type = null;
  $type = not_null($type);

  assertType("string", $type);
}

{
  /** @var int|null $type */
  $type = null;
  $type = not_null($type);

  assertType("int", $type);
}

{
  /** @var mixed $type */
  $type = null;
  $type = not_null($type);

  assertType("mixed", $type);
}

{
  class Clazz {
  }

  /** @var Clazz|null $type */
  $type = null;
  $type = not_null($type);

  assertType(Clazz::class, $type);
}

{
  /** @var int|false|null|string $type */
  $type = null;
  $type = not_null($type);

  assertType("int|string|false", $type);
}
