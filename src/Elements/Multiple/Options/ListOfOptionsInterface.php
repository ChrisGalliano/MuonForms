<?php
  declare(strict_types=1);

  namespace Muon\Elements\Multiple\Options;

  interface ListOfOptionsInterface
  {
    /**
     * @return OptionInterface[]|\Generator
     */
    public function all() : \Generator;
  }