<?php
  declare(strict_types=1);

  namespace Muon\Layout;

  use Muon\FormInterface;
  use Peony\Engine\EngineInterface;
  use Peony\Renderable\RenderableInterface;

  class FormLayout implements RenderableInterface
  {
    private FormInterface $form;


    public function __construct(FormInterface $form)
    {
      $this->form = $form;
    }


    public function render(EngineInterface $engine) : string
    {
      return $engine->render(
        __DIR__ . '/FormLayoutView.html',
        [
          'form' => $this->form,
          'engine' => $engine,
        ]
      );
    }
  }