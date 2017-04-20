<?php
namespace RegisterVinyl\Middleware\Vinyl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateInterface;
use RegisterVinyl\Entity\Vinyl;

class Table implements MiddlewareInterface
{
    private $db;
    private $twig;

    public function __construct(\PDO $db, TemplateInterface $twig)
    {
        $this->db = $db;
        $this->twig = $twig;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $total = Vinyl::getTotal($this->db);

        $page = $request->getAttribute('page');

        $vinyls = Vinyl::getToTable($this->db, $page ?? 1);

        return new \Zend\Diactoros\Response\HtmlResponse(
            $this->twig->render(
                'list',
                [
                    'base_url' => BASE_URL,
                    'title' => 'Lista de Vinyls',
                    'total' => $total,
                    'page' => $page,
                    'vinyls' => $vinyls
                ]
            )
        );
    }
}