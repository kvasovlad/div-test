<?php

namespace App\Services;

use App\Interfaces\MailServiceInterface;
use App\Models\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileMailService implements MailServiceInterface
{
    public function sendRequestResolved(Request $request): void
    {
        $content = $this->buildEmailContent($request);
        $filename = $this->generateFilename($request);

        Storage::disk('local')->put("emails/{$filename}", $content);
    }

    private function buildEmailContent(Request $request): string
    {
        return <<<EMAIL
        To: {$request->email}
        Subject: Ваша заявка #{$request->id} была обработана

        Уважаемый(ая) {$request->name},

        Ваша заявка была рассмотрена и обработана.

        Ваше сообщение:
        {$request->message}

        Ответ от поддержки:
        {$request->comment}

        С уважением,
        Служба поддержки

        Дата обработки: {$request->updated_at}
        EMAIL;
    }

    private function generateFilename(Request $request): string
    {
        $timestamp = now()->format('Y-m-d_His');
        $slug = Str::slug($request->name);

        return "request_{$request->id}_{$slug}_{$timestamp}.txt";
    }
}
