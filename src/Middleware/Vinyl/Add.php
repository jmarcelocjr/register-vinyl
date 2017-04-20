<?php
namespace RegisterVinyl\Middleware\Vinyl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use RegisterVinyl\Entity\Vinyl;

class Add implements MiddlewareInterface
{
    private $db;

    public function __construct(\Pdo $db)
    {
        $this->db = $db;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $files = $request->getUploadedFiles()['fotos'];

        $post = $request->getParsedBody();

        $vinyl = new Vinyl();

        $vinyl->setTitle($post['titulo'])
            ->setDescription($post['descricao'])
            ->setyear($post['ano'])
            ->setGenre($post['genero'])
            ->setPrice($post['preco']);

        if(!$vinyl->save($this->db)){
            $request = $request->withAttribute('add', false);
            return $delegate->process($request);
        }

        $request = $request->withAttribute('add', true);

        if(empty($files)){
            return $delegate->process($request);
        }

        foreach ($files as $i => $file) {
            if($file->getError() != UPLOAD_ERR_OK){
                continue;
            }

            $file->moveTo(BASE_PATH."/public/upload/vinyl-$i-{$vinyl->getId()}.jpg");
        }

        return $delegate->process($request);
    }
}