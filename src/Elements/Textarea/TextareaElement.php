<?php
  declare(strict_types=1);

  namespace Muon\Elements\Textarea;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Muon\Elements\Validation\Display\ErrorsWidget;
  use Muon\Elements\Validation\ElementValidationResult;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Pion\Spl\Types\String\StringInterface;
  use Pion\Spl\Types\String\Validation\StringValidatorInterface;
  use Pion\Validation\Result\ValidationResult;
  use Pion\Validation\Result\ValidationResultInterface;

  class TextareaElement implements FormElementInterface, StringInterface
  {
    private string $name;

    private string $value = '';

    private StringValidatorInterface $validator;

    private ValidationResultInterface $validationResult;


    public function __construct(string $name, StringValidatorInterface $validator)
    {
      $this->name = $name;
      $this->validator = $validator;
      $this->validationResult = new ValidationResult();
    }


    public function string() : string
    {
      return $this->value;
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      $this->setValue($parameters->has($this->name()) ? $parameters->require($this->name()) : '');
      $this->validationResult = $this->validator->validate($this);

      return new ElementValidationResultsCollection(
        new ElementValidationResult($this, $this->validationResult)
      );
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/TextareaElementView.html',
        [
          'errors' => (new ErrorsWidget($this->validationResult))->render($engine),
          'name' => $this->name(),
          'value' => $this->string(),
        ]
      );
    }


    public function setValue(string $value) : void
    {
      $this->value = $value;
    }
  }