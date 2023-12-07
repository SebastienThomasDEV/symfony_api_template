<?php

namespace App\Annotations;

use Symfony\Component\HttpFoundation\Request;
use Attribute;

/**
 * @Component
 * @ListensOn(value={"event1", "event2", "event3"})
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Test
{

    public function __construct(
        private $request = null
    )
    {
        $this->request = Request::createFromGlobals()->getContent();
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }


}