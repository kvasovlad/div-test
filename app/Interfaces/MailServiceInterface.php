<?php

namespace App\Interfaces;

use App\Models\Request;

interface MailServiceInterface
{
    public function sendRequestResolved(Request $request): void;
}
