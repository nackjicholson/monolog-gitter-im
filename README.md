monolog-gitter-im
=================

Sends [monolog](https://github.com/Seldaek/monolog) notifications through the [gitter.im](https://gitter.im) api to a
targeted gitter chat room.

#### Basic usage

```
// Default level is Logger::CRITICAL
$gitterHandler = new GitterImHandler('apiToken', 'roomId');

$logger = new Logger('gitterIm.example');
$logger->pushHandler($gitterHandler);

$logger->debug('debug will not go', ['ctx' => 'minutia']);
$logger->critical('A gitter.im critical monolog', ['ctx' => 'investigate']);
$logger->alert('A gitter.im alert monolog', ['ctx' => 'take action']);
$logger->emergency('A gitter.im emergency monolog', ['ctx' => 'boom!']);
```

This example will make separate requests to gitter api making one message for each of the monolog calls that are
`>= Logger::CRITICAL`. 

#### Wrap with BufferHandler

Wrapping the `GitterImHandler` with monolog's built in `BufferHandler` makes it possible for you
to only make one buffered message per execution of your program. All logs which are to be sent to Gitter are
buffered and then when the program exits, they are all sent to the chat room as one batched message.

Setup for that would look like this:

```
$gitterHandler = new GitterImHandler('apiToken', 'roomId');
$bufferHandler = new BufferHandler($gitterHandler);

$logger = new Logger('gitterIm.buffered.example');
$logger->pushHandler($bufferHandler);
```
