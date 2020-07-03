<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Radio\Multiple;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Input\Radio\RadioElement;
  use Muon\Elements\Multiple\Options\ListOfOptionsInterface;
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

  class ListOfRadiosElement implements FormElementInterface, StringInterface
  {
    private string $name;

    /**
     * @var RadioElement[]
     */
    private array $radios = [];

    private StringValidatorInterface $validator;

    private ValidationResultInterface $validationResult;


    public function __construct(string $name, ListOfOptionsInterface $options, StringValidatorInterface $validator)
    {
      $this->name = $name;
      foreach ($options->all() as $option) {
        $this->radios[] = new RadioElement($name, $option);
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
      foreach ($this->radios as $radio) {
        $radio->handle($parameters);
      }
      $this->validationResult = $this->validator->validate($this);

      return new ElementValidationResultsCollection(
        new ElementValidationResult($this, $this->validationResult)
      );
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/ListOfRadiosElementView.html',
        [
          'errors' => (new ErrorsWidget($this->validationResult))->render($engine),
          'radios' => $this->radios,
          'engine' => $engine,
        ]
      );
    }


    public function string() : string
    {
      $result = '';
      foreach ($this->radios as $radio) {
        if ($radio->bool()) {
          $result = $radio->value();
          break;
        }
      }

      return $result;
    }
  }