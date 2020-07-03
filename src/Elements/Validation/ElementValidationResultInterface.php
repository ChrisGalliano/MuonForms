<?php
  declare(strict_types=1);

  namespace Muon\Elements\Validation;

  use Muon\Elements\FormElementInterface;
  use Pion\Validation\Result\ValidationResultInterface;

  interface ElementValidationResultInterface
  {
    public function element(): FormElementInterface;

    public function result(): ValidationResultInterface;
  }