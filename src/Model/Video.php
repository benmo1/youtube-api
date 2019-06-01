<?php

namespace MorrisPhp\YouTubeApi\Model;

class Video
{

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $publishedAt;

    /**
     * Note this may be null if it hasn't
     * been persisted to the db yet
     *
     * @var ?int
     */
    private $id;

    /**
     * Video constructor.
     * @param int $id
     * @param string $title
     * @param \DateTime $publishedAt
     */
    public function __construct(string $title, \DateTime $publishedAt, int $id = null)
    {
        $this->title = $title;
        $this->publishedAt = $publishedAt;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
