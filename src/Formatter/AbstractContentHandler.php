<?php

namespace Nack\Monolog\Formatter;

use Monolog\Handler\AbstractProcessingHandler;

/**
 * General abstract class for handlers which send strings of content. i.e. Emails, chat messages, etc.
 *
 * This could replace the MailHandler, because MailHandler's name is less generic than it's functionality.
 * MailHandler also sends an extra array of records to it's send method which none of the concrete implementations
 * of email handlers actually use.
 *
 * @author Will Vaughn <willieviseoae@gmail.com>
 */
abstract class AbstractContentHandler extends AbstractProcessingHandler
{
    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records)
    {
        $messages = array();

        foreach ($records as $record) {
            if ($record['level'] < $this->level) {
                continue;
            }
            $messages[] = $this->processRecord($record);
        }

        if (!empty($messages)) {
            $this->send((string) $this->getFormatter()->formatBatch($messages));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->send((string) $record['formatted']);
    }

    /**
     * Send a log with the given string of content
     *
     * @param string $content
     */
    abstract protected function send($content);
}
