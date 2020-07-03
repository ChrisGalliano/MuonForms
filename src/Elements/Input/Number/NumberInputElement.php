<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Number;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Muon\Elements\Validation\Display\ErrorsWidget;
  use Muon\Elements\Validation\ElementValidationResult;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Pion\Spl\Types\Float\FloatInterface;
  use Pion\Spl\Types\Float\Validation\FloatValidatorInterface;
  use Pion\Validation\Result\ValidationResult;
  use Pion\Validation\Result\ValidationResultInterface;

  class NumberInputElement implements FormElementInterface, FloatInterface
  {
    private string $name;

    private FloatValidatorInterface $validator;

    private ValidationResultInterface $validationResult;

    private float $value = 0.0;


    public function __construct(string $name, FloatValidatorInterface $validator)
    {
      $this->name = $name;
      $this->validator = $validator;
      $this->validationResult = new ValidationResult();
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      $this->setValue($parameters->has($this->name()) ? (float) $parameters->require($this->name()) : 0.0);
      $this->validationResult = $this->validator->validate($this);

      return new ElementValidationResultsCollection(
        new ElementValidationResult($this, $this->validationResult)
      );
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/NumberInputElementView.html',
        [
          'errors' => (new ErrorsWidget($this->validationResult))->render($engine),
          'name' => $this->name(),
          'value' => $this->value(),
        ]
      );
    }


    public function value() : float
    {
      return $this->value;
    }


    public function setValue(float $value) : void
    {
      $this->value = $value;
    }
  }