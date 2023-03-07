<?php

namespace KphpTests\Type;

use PHPStan\Testing\TypeInferenceTestCase;

class GeneralTypeTest extends TypeInferenceTestCase {

  /**
   * @return iterable<mixed>
   */
  public function dataFileAsserts(): iterable {
    yield from $this->gatherAssertTypes(__DIR__ . '/data/not_null.php');
    yield from $this->gatherAssertTypes(__DIR__ . '/data/not_false.php');
  }

  /**
   * @dataProvider dataFileAsserts
   */
  public function testFileAsserts(
    string $assertType,
    string $file,
    ...$args
  ): void {
    $this->assertFileAsserts($assertType, $file, ...$args);
  }

  public static function getAdditionalConfigFiles(): array {
    return [__DIR__ . '/../../extension.neon'];
  }
}
