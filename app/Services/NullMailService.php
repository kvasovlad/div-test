<?php

namespace App\Services;

use App\Interfaces\MailServiceInterface;
use App\Models\Request;

class NullMailService implements MailServiceInterface
{
    public function sendRequestResolved(Request $request): void
    {
    }
}
