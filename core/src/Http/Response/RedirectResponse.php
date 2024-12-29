<?php 

namespace Timon\PhpFramework\Http\Response;

use Timon\PhpFramework\Http\Response\Response;

class RedirectResponse extends Response
{

    public function __construct(string $url)
    {
        parent::__construct('', ['location' => $url], 302);
    }
    public function send()
    {
        return header("location:{$this->getHeader('location')}", true, $this->getStatusCode());
        exit;
    }
}