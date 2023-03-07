<?php

declare(strict_types = 1);

namespace KphpPHPStan\Types;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\BooleanType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;

class NotFalseFunctionDynamicReturnTypeExtension implements DynamicFunctionReturnTypeExtension {
  public function isFunctionSupported(FunctionReflection $functionReflection): bool {
    return $functionReflection->getName() === "not_false";
  }

  public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): ?Type {
    $args = $functionCall->getArgs();
    if (count($args) < 1) {
      return null;
    }

    $type = $scope->getType($args[0]->value);
    if ($type->isFalse()->yes()) {
      throw new ShouldNotHappenException();
    }

    if ($type instanceof MixedType && $type->isExplicitMixed()) {
      return new MixedType();
    }

    return self::removeFalse($type);
  }

  static function removeFalse(Type $type): Type {
    if ($type instanceof BooleanType) {
      return $type;
    }

    if (!($type instanceof UnionType)) {
      throw new ShouldNotHappenException();
    }

    $types = [];
    foreach ($type->getTypes() as $innerType) {
      if ($innerType->isFalse()->yes()) {
        continue;
      }

      $types[] = $innerType;
    }

    return TypeCombinator::union(...$types);
  }
}
