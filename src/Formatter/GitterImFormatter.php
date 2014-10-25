<?php

namespace Nack\Monolog\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

/**
 * Formats incoming records into log lines augmented with a gitter emoji code.
 *
 * @author Will Vaughn <willieviseoae@gmail.com>
 */
class GitterImFormatter extends LineFormatter
{
    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return string The formatted record
     */
    public function format(array $record)
    {
        $emoji = $this->getEmojiForLevel($record['level']);
        $output = parent::format($record);

        return $emoji . $output;
    }

    /**
     * Returns hash of logger levels to their associated emoji code.
     *
     * @return array
     */
    protected function getLevelEmojiMap()
    {
        return array(
            Logger::DEBUG => ':pencil2:',
            Logger::INFO => ':white_check_mark:',
            Logger::NOTICE => ':loudspeaker:',
            Logger::WARNING => ':warning:',
            Logger::ERROR => ':bangbang:',
            Logger::CRITICAL => ':fire:',
            Logger::ALERT => ':no_entry:',
            Logger::EMERGENCY => ':boom:'
        );
    }

    /**
     * Retrieves a Gitter Emoji code for the given log level.
     *
     * @param $level
     * @return string
     * @see http://www.emoji-cheat-sheet.com/
     */
    protected function getEmojiForLevel($level)
    {
        $levelEmojiMap = $this->getLevelEmojiMap();
        return $levelEmojiMap[$level];
    }
}
