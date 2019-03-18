<?php

namespace VanOns\Laraberg\Test;

use Laraberg;
use VanOns\Laraberg\Test\TestCase;

class LarabergTest extends TestCase
{
    /**
     * Check that the do stuff function returns void
     * @return void
     */
    public function testDoStuffReturnsVoid()
    {
        $this->assertSame(Laraberg::doStuff(), 'Did stuff');
    }
}
