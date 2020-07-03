<?php

  declare(strict_types=1);

  namespace Muon;

  use Muon\Handling\HandlingResultInterface;
  use Peony\Renderable\RenderableInterface;
  use Pion\Http\Request\Method\RequestMethodInterface;
  use Pion\Http\Request\Parameters\ParametersInterface;
  use Psr\Http\Message\UriInterface;

  interface FormInterface extends RenderableInterface
  {
    public function handle(ParametersInterface $parameters) : HandlingResultInterface;


    public function action() : UriInterface;


    public function name() : string;


    public function method() : RequestMethodInterface;
  }