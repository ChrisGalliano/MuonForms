<?php
  declare(strict_types=1);

  namespace Muon\Handling;

  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;

  interface HandlingResultInterface
  {
    public function isSubmitted() : bool;


    public function results() : ElementValidationResultsCollectionInterface;
  }