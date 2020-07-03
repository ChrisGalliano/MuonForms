<?php
  declare(strict_types=1);

  namespace Muon\Elements\Multiple\Options;

  interface OptionInterface
  {
    public function value() : string;


    public function label() : string;
  }