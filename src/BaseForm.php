<?php
  declare(strict_types=1);

  namespace Muon;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Handling\HandlingResult;
  use Muon\Handling\HandlingResultInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;

  abstract class BaseForm implements FormInterface
  {
    /**
     * @var FormElementInterface[]
     */
    private array $elements;


    public function __construct(FormElementInterface...$elements)
    {
      $this->elements = $elements;
    }


    public function handle(ParametersInterface $parameters) : HandlingResultInterface
    {
      $isSubmitted = $parameters->has($this->name());
      $validationResult = new ElementValidationResultsCollection();
      if ($isSubmitted) {
        foreach ($this->elements as $element) {
          $validationResult = $validationResult->merge($element->handle($parameters));
        }
      }

      return new HandlingResult($isSubmitted, $validationResult);
    }
  }