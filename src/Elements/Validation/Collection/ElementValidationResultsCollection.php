<?php
  declare(strict_types=1);

  namespace Muon\Elements\Validation\Collection;

  use Muon\Elements\Validation\ElementValidationResultInterface;

  class ElementValidationResultsCollection implements ElementValidationResultsCollectionInterface
  {
    /**
     * @var ElementValidationResultInterface[]
     */
    private array $results = [];


    public function __construct(ElementValidationResultInterface...$results)
    {
      foreach ($results as $result) {
        $this->results[$result->element()->name()] = $result;
      }
    }


    public function merge(ElementValidationResultsCollectionInterface $collection) : ElementValidationResultsCollectionInterface
    {
      $results = $this->results;
      foreach ($collection->all() as $result) {
        $results[$result->element()->name()] = $result;
      }

      return new self(...array_values($results));
    }


    public function isValid() : bool
    {
      $isValid = true;
      foreach ($this->all() as $result) {
        if (!$result->result()->isValid()) {
          $isValid = false;
          break;
        }
      }

      return $isValid;
    }


    /**
     * @return ElementValidationResultInterface[]
     */
    public function all() : array
    {
      return $this->results;
    }


    /**
     * @throws UndefinedValidationResultException
     */
    public function get(string $name) : ElementValidationResultInterface
    {
      if (\array_key_exists($name, $this->all())) {
        return $this->all()[$name];
      }
      throw new UndefinedValidationResultException($name);
    }
  }