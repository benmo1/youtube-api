<?php

namespace MorrisPhp\YouTubeApi\Model;

class Channel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $channelName;

    /**
     * Channel constructor.
     * @param int $id
     * @param string $channelName
     */
    public function __construct(int $id, string $channelName)
    {
        $this->id = $id;
        $this->channelName = $channelName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return $this->channelName;
    }
}
