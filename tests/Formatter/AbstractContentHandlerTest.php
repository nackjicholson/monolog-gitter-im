<?php

namespace Nack\Monolog\Formatter;

class AbstractContentHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testSendsBatchedRecordContentAsString()
    {
        $sut = $this->getMockForAbstractClass(__NAMESPACE__ . '\\AbstractContentHandler');

        $record = array(
            'message' => 'test.message',
            'context' => array(),
            'level' => 100,
            'level_name' => 'DEBUG',
            'channel' => 'test.channel',
            'datetime' => new \DateTime,
            'extra' => array()
        );

        $content = '['.date('Y-m-d H:i:s').'] test.channel.DEBUG: test.message [] []'."\n";

        $sut->expects($this->once())->method('send')->with($content);

        /** @var AbstractContentHandler $sut */
        $sut->handleBatch(array($record));
    }

    public function testDoesNotSendMessagesBelowTheSetLevelWhenBatching()
    {
        $sut = $this->getMockForAbstractClass(__NAMESPACE__ . '\\AbstractContentHandler');

        // Below debug, won't be sent.
        $record = array(
            'level' => 1
        );

        $sut->expects($this->never())->method('send')->withAnyParameters();

        /** @var AbstractContentHandler $sut */
        $sut->handleBatch(array($record));
    }

    public function testSendsSingularRecordContentAsString()
    {
        $sut = $this->getMockForAbstractClass(__NAMESPACE__ . '\\AbstractContentHandler');

        $record = array(
            'message' => 'test.message',
            'context' => array(),
            'level' => 100,
            'level_name' => 'DEBUG',
            'channel' => 'test.channel',
            'datetime' => new \DateTime,
            'extra' => array()
        );

        $content = '['.date('Y-m-d H:i:s').'] test.channel.DEBUG: test.message [] []'."\n";

        $sut->expects($this->once())->method('send')->with($content);

        /** @var AbstractContentHandler $sut */
        $sut->handle($record);
    }
}
