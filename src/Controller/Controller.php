<?php

namespace MorrisPhp\YouTubeApi\Controller;

use MorrisPhp\YouTubeApi\Exception\NotFoundException;
use MorrisPhp\YouTubeApi\Repository\ChannelRepository as ChannelRepository;
use MorrisPhp\YouTubeApi\Repository\VideoRepository as VideoRepository;
use MorrisPhp\YouTubeApi\YouTube\Service as YoutubeServiceWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    /**
     * @var YouTubeServiceWrapper
     */
    private $service;

    /**
     * @var ChannelRepository
     */
    private $channelRepository;

    /**
     * @var VideoRepository
     */
    private $videoRepository;

    /**
     * Controller constructor.
     * @param YouTubeServiceWrapper $service
     * @param ChannelRepository $channelRepository
     * @param VideoRepository $videoRepository
     */
    public function __construct(
        YouTubeServiceWrapper $service,
        ChannelRepository $channelRepository,
        VideoRepository $videoRepository
    ) {
        $this->service = $service;
        $this->channelRepository = $channelRepository;
        $this->videoRepository = $videoRepository;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Clear previous search
        $this->videoRepository->deleteAll();

        $channels = $this->channelRepository->getAll();

        foreach ($channels as $channel) {
            $id = $this->service->getIdForChannel($channel->getChannelName());

            $videos = $this->service->getVideosForChannel($id);

            $this->videoRepository->addMultiple($videos);
        }

        return $response->withStatus(200);
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Clean from middleware
        $params = $request->getQueryParams();

        if (!empty($params['q'])) {
            $videos = $this->videoRepository->getAllByTerm($params['q']);
        } else {
            $videos = $this->videoRepository->getAll();
        }

        $response->getBody()->write(json_encode($videos));
        $response->getBody()->rewind();

        return $response->withStatus(200);
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $video = $this->videoRepository->get($args['id']); // Clean from route regex
        } catch (NotFoundException $ex) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($video));
        $response->getBody()->rewind();

        return $response->withStatus(200);
    }

    public function destroy(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $success = $this->videoRepository->delete($args['id']); // Clean from route regex

        return $response->withStatus($success ? 204 : 404);
    }
}
