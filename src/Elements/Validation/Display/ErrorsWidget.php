<?php
  declare(strict_types=1);

  namespace Muon\Elements\Validation\Display;

  use Peony\Engine\EngineInterface;
  use Peony\Renderable\RenderableInterface;
  use Pion\Validation\Result\ValidationResult;

  class ErrorsWidget implements RenderableInterface
  {
    /**
     * @var ValidationResult
     */
    private ValidationResult $validationResult;


    public function __construct(ValidationResult $validationResult)
    {
      $this->validationResult = $validationResult;
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/ErrorsWidgetView.html',
        [
          'validationResult' => $this->validationResult,
        ]
      );
    }
  }