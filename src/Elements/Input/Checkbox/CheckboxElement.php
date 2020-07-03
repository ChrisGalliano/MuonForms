<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Checkbox;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Multiple\Options\OptionInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Muon\Elements\Validation\Display\ErrorsWidget;
  use Muon\Elements\Validation\ElementValidationResult;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Pion\Spl\Types\Boolean\BooleanInterface;
  use Pion\Spl\Types\Boolean\Validation\BooleanValidatorInterface;
  use Pion\Validation\Result\ValidationResult;
  use Pion\Validation\Result\ValidationResultInterface;

  class CheckboxElement implements FormElementInterface, BooleanInterface
  {
    private string $name;

    private OptionInterface $option;

    private bool $checked = false;

    private BooleanValidatorInterface $validator;

    private ValidationResultInterface $validationResult;


    public function __construct(string $name, OptionInterface $option, BooleanValidatorInterface $validator)
    {
      $this->name = $name;
      $this->option = $option;
      $this->validator = $validator;
      $this->validationResult = new ValidationResult();
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      $this->checked = $parameters->has($this->name());
      $this->validationResult = $this->validator->validate($this);

      return new ElementValidationResultsCollection(
        new ElementValidationResult($this, $this->validationResult)
      );
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/CheckboxElementView.html',
        [
          'errors' => (new ErrorsWidget($this->validationResult))->render($engine),
          'name' => $this->name(),
          'checked' => $this->bool(),
          'label' => $this->option->label(),
        ]
      );
    }


    public function bool() : bool
    {
      return $this->checked;
    }


    public function option() : OptionInterface
    {
      return $this->option;
    }


    public function setChecked(bool $checked) : void
    {
      $this->checked = $checked;
    }
  }