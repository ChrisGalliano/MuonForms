<?php
  declare(strict_types=1);

  namespace Muon\Elements\Input\Submit;

  use Muon\Elements\FormElementInterface;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollection;
  use Muon\Elements\Validation\Collection\ElementValidationResultsCollectionInterface;
  use Peony\Engine\EngineInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;

  class SubmitElement implements FormElementInterface
  {
    private string $text;

    private string $name;


    public function __construct(string $text, string $name = null)
    {
      $this->text = $text;
      $this->name = $name ?? 'submit';
    }


    public function name() : string
    {
      return $this->name;
    }


    public function handle(ParametersInterface $parameters) : ElementValidationResultsCollectionInterface
    {
      return new ElementValidationResultsCollection();
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/SubmitElementView.html',
        [
          'name' => $this->name(),
          'text' => $this->text,
        ]
      );
    }
  }