<?php
  declare(strict_types=1);

  namespace Muon\Elements\Validation;

  use Muon\Elements\FormElementInterface;
  use Pion\Validation\Result\ValidationResultInterface;

  class ElementValidationResult implements ElementValidationResultInterface
  {
    private FormElementInterface $element;

    private ValidationResultInterface $result;


    public function __construct(FormElementInterface $element, ValidationResultInterface $result)
    {
      $this->element = $element;
      $this->result = $result;
    }


    public function element() : FormElementInterface
    {
      return $this->element;
    }


    public function result() : ValidationResultInterface
    {
      return $this->result;
    }
  }