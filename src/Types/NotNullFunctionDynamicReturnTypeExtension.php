<?php

declare(strict_types = 1);

namespace KphpPHPStan\Types;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\MixedType;

class NotNullFunctionDynamicReturnTypeExtension implements DynamicFunctionReturnTypeExtension {
  public function isFunctionSupported(FunctionReflection $functionReflection): bool {
    return $functionReflection->getName() === "not_null";
  }

  public function getTypeFromFunctionCall(FunctionReflection $functionReflection, FuncCall $functionCall, Scope $scope): ?\PHPStan\Type\Type {
    $args = $functionCall->getArgs();
    if (count($args) < 1) {
      return null;
    }

    $type = $scope->getType($args[0]->value);
    if ($type->isNull()->yes()) {
      throw new ShouldNotHappenException();
    }

    if ($type instanceof MixedType && $type->isExplicitMixed()) {
      return new MixedType();
    }

    return $type;
  }
}
