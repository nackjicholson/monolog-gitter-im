<?php

namespace Nack\Monolog\Formatter;

use Monolog\Logger;

class GitterImFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param int $level
     * @param string $levelName
     * @param string $emoji
     *
     * @dataProvider levelsProvider
     */
    public function testAddsEmojiToFormattedLines($level, $levelName, $emoji)
    {
        $sut = new GitterImFormatter();

        $message = 'test.message';
        $channel = 'test.channel';

        $record = array(
            'message' => $message,
            'context' => array(),
            'level' => $level,
            'level_name' => $levelName,
            'channel' => $channel,
            'datetime' => new \DateTime,
            'extra' => array()
        );

        $dateStr = date('Y-m-d H:i:s');
        $content = "{$emoji}[$dateStr] $channel.$levelName: $message [] []\n";

        $this->assertEquals($content, $sut->format($record));
    }

    public function levelsProvider()
    {
        return array(
            array(Logger::DEBUG, Logger::getLevelName(Logger::DEBUG), ':pencil2:'),
            array(Logger::INFO, Logger::getLevelName(Logger::INFO), ':white_check_mark:'),
            array(Logger::NOTICE, Logger::getLevelName(Logger::NOTICE), ':loudspeaker:'),
            array(Logger::WARNING, Logger::getLevelName(Logger::WARNING), ':warning:'),
            array(Logger::ERROR, Logger::getLevelName(Logger::ERROR), ':bangbang:'),
            array(Logger::CRITICAL, Logger::getLevelName(Logger::CRITICAL), ':fire:'),
            array(Logger::ALERT, Logger::getLevelName(Logger::ALERT), ':no_entry:'),
            array(Logger::EMERGENCY, Logger::getLevelName(Logger::EMERGENCY), ':boom:'),
        );
    }
}
