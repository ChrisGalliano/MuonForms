<?php
  declare(strict_types=1);

  namespace Muon\Elements\Multiple\Options;

  class PredefinedOption implements OptionInterface
  {
    private string $value;

    private string $label;


    public function __construct(string $value, string $label = null)
    {
      $this->value = $value;
      $this->label = $label ?? $value;
    }


    public function value() : string
    {
      return $this->value;
    }


    public function label() : string
    {
      return $this->label;
    }
  }