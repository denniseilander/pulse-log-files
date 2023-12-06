<?php

declare(strict_types=1);

namespace Denniseilander\LogFiles\DataTransferObjects;

use Illuminate\Support\Collection;
use Illuminate\Support\Number;

class LogFile
{
    public function __construct(
        public string $name,
        public string $path,
        public int $size,
        public string $readableSize,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'size' => $this->size,
            'readable_size' => $this->readableSize,
        ];
    }

    public static function fromPath(string $path): self
    {
        return new self(
            name: basename($path),
            path: $path,
            size: filesize($path),
            readableSize: Number::fileSize(filesize($path)),
        );
    }

    /**
     * @throws \JsonException
     */
    public static function multipleFromJson(string $json): Collection
    {
        $data = json_decode(
            json: $json,
            associative: true,
            depth: 512,
            flags: JSON_THROW_ON_ERROR
        );

        return Collection::make($data)->map(function ($item) {
            return new self(...array_values($item));
        });
    }
}
