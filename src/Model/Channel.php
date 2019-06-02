<?php

namespace MorrisPhp\YouTubeApi\Model;

class Channel
{
    /**
     * @var ?int
     */
    private $id;

    /**
     * @var ?string
     */
    private $channelName;

    /**
     * Channel constructor.
     * @param array $props
     */
    public function __construct(array $props)
    {
        $this->setId($props['id'] ?? null);
        $this->setChannelName($props['channel_name'] ?? null);
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = (int)$id;
    }

    /**
     * @return mixed
     */
    public function getChannelName(): ?string
    {
        return $this->channelName;
    }

    /**
     * @param mixed $channelName
     */
    public function setChannelName($channelName): void
    {
        $this->channelName = (string)$channelName;
    }
}
