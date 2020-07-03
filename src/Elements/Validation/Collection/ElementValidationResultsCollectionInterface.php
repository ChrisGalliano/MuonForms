<?php
  declare(strict_types=1);

  namespace Muon\Elements\Validation\Collection;

  use Muon\Elements\Validation\ElementValidationResultInterface;

  interface ElementValidationResultsCollectionInterface
  {
    public function merge(ElementValidationResultsCollectionInterface $collection) : self;


    public function isValid() : bool;


    public function get(string $name) : ElementValidationResultInterface;


    /**
     * @return ElementValidationResultInterface[]
     */
    public function all() : array;
  }