<?php

namespace Nack\Monolog\Handler;

use Monolog\Logger;
use Nack\Monolog\Formatter\GitterImFormatter;

/**
 * Sends notifications through the gitter.im api to a targeted gitter chat room.
 *
 * @author Will Vaughn <willieviseoae@gmail.com>
 * @see https://developer.gitter.im/docs/welcome
 */
class GitterImHandler extends AbstractContentHandler
{
    const HOST = 'api.gitter.im';
    const ROOMS_ENDPOINT = 'v1/rooms';
    const MESSAGES_ENDPOINT = 'chatMessages';

    /** @var string User API token for gitter.im authentication */
    protected $token;

    /** @var string Id of the room receiving the log message(s). */
    protected $roomId;

    /**
     * Constructor.
     *
     * @param string $token User API token for gitter.im
     * @param string $roomId Id of the room receiving the log message(s).
     * @param int $level  The minimum logging level at which this handler will be triggered
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($token, $roomId, $level = Logger::CRITICAL, $bubble = true)
    {
        if (!extension_loaded('curl')) {
            throw new \LogicException('The curl extension is needed to use the GitterHandler');
        }

        parent::__construct($level, $bubble);

        $this->token = $token;
        $this->roomId = $roomId;
    }

    /**
     * Send content to a gitter.im chat room through the rest api.
     *
     * @param string $content
     * @see https://developer.gitter.im/docs/messages-resource
     */
    protected function send($content)
    {
        $url = sprintf('https://%s/%s/%s/%s', self::HOST, self::ROOMS_ENDPOINT, $this->roomId, self::MESSAGES_ENDPOINT);
        $data = json_encode(['text' => $content]);
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "Authorization: Bearer {$this->token}"
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter()
    {
        return new GitterImFormatter();
    }
}
