<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Menu aktiv deyil</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #0f172a;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 28px;
            padding: 26px;
            text-align: center;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
        }

        .icon {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            background: #fff7ed;
            color: #f97316;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin: 0 auto 18px;
        }

        h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 900;
        }

        p {
            margin-top: 10px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="icon">QR</div>
        <h1>{{ $message ?? 'QR Menu aktiv deyil' }}</h1>
        <p>
            {{ $restaurant->name }} üçün QR menyu hazırda aktiv deyil.
            Zəhmət olmasa restoran əməkdaşına müraciət edin.
        </p>
    </div>
</body>

</html>