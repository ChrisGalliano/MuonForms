<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Checkbox\Multiple;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Input\Checkbox\CheckboxElement;
  use Muon\Elements\Multiple\Options\ListOfOptionsInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Muon\Elements\Validation\Display\ErrorsWidget;
  use Muon\Elements\Validation\ElementValidationResult;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Pion\Spl\Types\Boolean\BooleanInterface;
  use Pion\Spl\Types\Boolean\Multiple\ListOfBooleansInterface;
  use Pion\Spl\Types\Boolean\Multiple\Validation\ListOfBooleansValidatorInterface;
  use Pion\Spl\Types\Boolean\Validation\DummyBooleanValidator;
  use Pion\Validation\Result\ValidationResult;
  use Pion\Validation\Result\ValidationResultInterface;

  class ListOfCheckboxesElement implements FormElementInterface, ListOfBooleansInterface
  {
    private string $name;

    /**
     * @var CheckboxElement[]
     */
    private array $checkboxes = [];

    private ListOfBooleansValidatorInterface $validator;

    private ValidationResultInterface $validationResult;


    public function __construct(
      string $name, ListOfOptionsInterface $options, ListOfBooleansValidatorInterface $validator
    )
    {
      $this->name = $name;
      foreach ($options->all() as $index => $option) {
        $this->checkboxes[] = new CheckboxElement($this->name . "_$index", $option, new DummyBooleanValidator());
      }
      $this->validator = $validator;
      $this->validationResult = new ValidationResult();
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      foreach ($this->checkboxes() as $checkbox) {
        $checkbox->handle($parameters);
      }
      $this->validationResult = $this->validator->validate($this);

      return new ElementValidationResultsCollection(
        new ElementValidationResult($this, $this->validationResult)
      );
    }


    /**
     * @return CheckboxElement[]
     */
    public function checkboxes() : array
    {
      return $this->checkboxes;
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(__DIR__ . '/ListOfCheckboxesView.html',
        [
          'errors' => (new ErrorsWidget($this->validationResult))->render($engine),
          'engine' => $engine,
          'checkboxes' => $this->checkboxes(),
        ]
      );
    }


    /**
     * @return BooleanInterface[]|\Generator
     */
    public function booleans() : \Generator
    {
      yield from $this->checkboxes();
    }
  }