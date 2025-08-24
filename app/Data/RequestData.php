<?php

namespace App\Data;

use App\Enums\RequestStatusesEnum;
use DateTime;
use Spatie\LaravelData\Data;

class RequestData extends Data
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $email,
        public ?string $message,
        public ?RequestStatusesEnum $status,
        public ?string $comment,
        public ?DateTime $created_at,
        public ?DateTime $updated_at
    )
    {
    }

    public function toArray(): array
    {
        return array_filter(parent::toArray(), fn($value) => $value !== null);
    }
}
