<?php
namespace RegisterVinyl\Middleware\Vinyl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use RegisterVinyl\Entity\Vinyl;

class Delete implements MiddlewareInterface
{
    private $db;

    public function __construct(\Pdo $db)
    {
        $this->db = $db;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = $request->getAttribute('id');

        $vinyl = new Vinyl();
        $vinyl->setId($id);

        if(!$vinyl->delete($this->db)){
            $request = $request->withAttribute('delete', false);
            return $delegate->process($request);
        }

        $request = $request->withAttribute('delete', true);
        return $delegate->process($request);
    }
}