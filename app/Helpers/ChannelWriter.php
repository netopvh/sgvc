<?php

namespace App\Helpers;

use Monolog\Logger;
use Psr\Log\InvalidArgumentException;

use App\Helpers\ChannelStreamHandler;

class ChannelWriter
{
    /**
     * The Log channels.
     *
     * @var array
     */
    protected $channels = [
        'event' => [
            'path' => 'logs/audit.log',
            'level' => Logger::INFO
        ],
        'audit' => [
            'path' => 'logs/audit.log',
            'level' => Logger::INFO
        ]
    ];

    /**
     * The Log levels.
     *
     * @var array
     */
    protected $levels = [
        'debug'     => Logger::DEBUG,
        'info'      => Logger::INFO,
        'notice'    => Logger::NOTICE,
        'warning'   => Logger::WARNING,
        'error'     => Logger::ERROR,
        'critical'  => Logger::CRITICAL,
        'alert'     => Logger::ALERT,
        'emergency' => Logger::EMERGENCY,
    ];

    public function __construct() {}

    /**
     * Write to log based on the given channel and log level set
     *
     * @param type $channel
     * @param type $message
     * @param array $context
     * @throws InvalidArgumentException
     */
    public function writeLog( $channel, $level,$message, array $context = [])
    {
        if (!in_array($channel, array_keys($this->channels))) {
            throw new InvalidArgumentException('Invalid channel used.');
        }

        $logger = \App::make("{$channel}log");
        $channelHandler = new ChannelStreamHandler(
            $channel,
            storage_path() . '/' . $this->channels[$channel]['path'],
            $this->channels[$channel]['level']
        );
        $logger->pushHandler($channelHandler);
        $logger->{$level}($message);
    }

    public function write($channel, $message, array $context = []){
        //get method name for the associated level
        $level = array_flip( $this->levels )[$this->channels[$channel]['level']];
        //write to log
        $this->writeLog($channel, $level, $message, $context);
    }

    //alert('event','Message');
    function __call($func, $params){
        if(in_array($func, array_keys($this->levels))){
            return $this->writeLog($params[0], $func, $params[1]);
        }
    }

    public function info($channel, $message, array $context = [])
    {
        $level = array_flip($this->levels)[$this->channels[$channel]['level']];
        $this->writeLog($channel, $level, $message, $context);
    }

}