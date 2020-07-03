<?php
  declare(strict_types=1);

  namespace Muon\Elements\Multiple\Options;

  class PredefinedListOfOptions implements ListOfOptionsInterface
  {
    /**
     * @var OptionInterface[]
     */
    private array $options;


    public function __construct(OptionInterface...$options)
    {
      $this->options = $options;
    }


    public function add(OptionInterface $option) : void
    {
      $this->options[] = $option;
    }


    /**
     * @return OptionInterface[]|\Generator
     */
    public function all() : \Generator
    {
      yield from $this->options;
    }
  }