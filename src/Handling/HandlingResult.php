<?php
  declare(strict_types=1);

  namespace Muon\Handling;

  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;

  class HandlingResult implements HandlingResultInterface
  {
    private bool $isSubmitted;

    private ElementValidationResultsCollectionInterface $result;


    public function __construct(bool $isSubmitted, ElementValidationResultsCollectionInterface $result)
    {
      $this->isSubmitted = $isSubmitted;
      $this->result = $result;
    }


    public function isSubmitted() : bool
    {
      return $this->isSubmitted;
    }


    public function results() : ElementValidationResultsCollectionInterface
    {
      return $this->result;
    }
  }