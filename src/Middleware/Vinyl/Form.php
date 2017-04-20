<?php
namespace RegisterVinyl\Middleware\Vinyl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateInterface;

class Form implements MiddlewareInterface
{
    private $twig;

    public function __construct(TemplateInterface $twig)
    {
        $this->twig = $twig;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = [
            'base_url' => BASE_URL,
            'title' => "Cadastro Vinyl"
        ];

        $vinyl = $request->getAttribute('vinyl', false);

        if(!$vinyl){
            $data['vinyl'] = $vinyl;
        }

        return new \Zend\Diactoros\Response\HtmlResponse(
            $this->twig->render(
                'form',
                $data
            )
        );
    }
}