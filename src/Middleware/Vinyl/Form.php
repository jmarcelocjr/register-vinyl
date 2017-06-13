<?php
namespace RegisterVinyl\Middleware\Vinyl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateInterface;

class Form implements MiddlewareInterface
{
    private $twig;
    private $db;

    public function __construct($db, TemplateInterface $twig)
    {
        $this->twig = $twig;
        $this->db = $db;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = [
            'base_url' => BASE_URL,
            'title' => "Cadastro Vinyl"
        ];

        $id = $request->getAttribute('id', false);

        if($id) {
            $data['vinyl'] = \RegisterVinyl\Entity\Vinyl::get($this->db, $id);
        }

        return new \Zend\Diactoros\Response\HtmlResponse(
            $this->twig->render(
                'form',
                $data
            )
        );
    }
}