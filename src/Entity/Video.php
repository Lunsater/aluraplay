<?php

namespace Alura\Mvc\Entity;

use http\Exception\InvalidArgumentException;

class Video
{
    public readonly int $id;
    public readonly string $url;
    private ?string $filePath;

    public function __construct(string $url, public readonly string $title)
    {
        $this->setUrl($url);
    }

    private function setUrl(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string|null $filePath
     */
    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}