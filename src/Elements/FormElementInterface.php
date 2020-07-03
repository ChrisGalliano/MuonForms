<?php
  declare(strict_types=1);

  namespace Muon\Elements;

  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;

  interface FormElementInterface
  {
    public function name() : string;


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface;


    public function render(EngineInterface $engine) : string;
  }