<?php

namespace Nack\Monolog\Handler;

class GitterImHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeInstantiatedAndProvidesDefaultFormatter()
    {
        // The curl extension is not worth testing, it's really difficult. But it does leave a coverage gap though.
        // This test will at least cover basic instantiation of the class and the getDefaultFormatter method.
        $sut = new GitterImHandler('foo', 'bar');
        $this->assertInstanceOf('Nack\\Monolog\\Formatter\\GitterImFormatter', $sut->getFormatter());
        $this->assertAttributeEquals('foo', 'token', $sut);
        $this->assertAttributeEquals('bar', 'roomId', $sut);
    }
}
