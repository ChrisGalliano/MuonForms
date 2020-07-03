<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Radio;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Multiple\Options\OptionInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Pion\Spl\Types\Boolean\BooleanInterface;

  class RadioElement implements FormElementInterface, BooleanInterface
  {
    private bool $isChecked = false;

    private string $name;

    private OptionInterface $option;


    public function __construct(string $name, OptionInterface $option)
    {
      $this->name = $name;
      $this->option = $option;
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      $this->isChecked = $parameters->has($this->name()) && $parameters->require($this->name()) === $this->value();

      return new ElementValidationResultsCollection();
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/RadioElementView.html',
        [
          'name' => $this->name(),
          'checked' => $this->bool(),
          'option' => $this->option,
        ]
      );
    }


    public function bool() : bool
    {
      return $this->isChecked;
    }


    public function value() : string
    {
      return $this->option->value();
    }
  }