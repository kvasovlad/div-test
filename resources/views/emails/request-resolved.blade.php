<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ваша заявка обработана</title>
</head>
<body>
<h2>Уважаемый(ая) {{ $request->name }},</h2>

<p>Ваша заявка #{{ $request->id }} была рассмотрена и обработана.</p>

<h3>Ваше сообщение:</h3>
<p>{{ $request->message }}</p>

<h3>Ответ от поддержки:</h3>
<p>{{ $request->comment }}</p>

<hr>

<p>С уважением,<br>
    Служба поддержки</p>

<p><small>Дата обработки: {{ $request->updated_at->format('d.m.Y H:i') }}</small></p>
</body>
</html>
