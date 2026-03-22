<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .card { background: #fff; border-radius: 12px; padding: 32px; max-width: 520px; margin: 0 auto; }
        .badge { display: inline-block; background: #f3e8ff; color: #7c3aed; padding: 4px 12px; border-radius: 50px; font-size: 12px; margin-bottom: 24px; }
        h2 { margin: 0 0 24px; color: #111; }
        .field { margin-bottom: 16px; }
        .label { font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .value { font-size: 15px; color: #222; }
        .desc { background: #f9f9f9; border-radius: 8px; padding: 16px; font-size: 14px; color: #444; line-height: 1.6; }
        .refs { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
        .refs img { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
        .footer { text-align: center; font-size: 12px; color: #aaa; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">Nueva solicitud</div>
        <h2>{{ $clientName }} quiere una comisión</h2>

        <div class="field">
            <div class="label">Nombre</div>
            <div class="value">{{ $clientName }}</div>
        </div>
        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $clientEmail }}">{{ $clientEmail }}</a></div>
        </div>
        <div class="field">
            <div class="label">Tipo de comisión</div>
            <div class="value">{{ ucfirst($commissionType) }}</div>
        </div>
        <div class="field">
            <div class="label">Descripción</div>
            <div class="desc">{{ $description }}</div>
        </div>

        @if($references->isNotEmpty())
        <div class="field">
            <div class="label">Imágenes de referencia</div>
            <div class="value">{{ $references->count() }} imagen(es) adjunta(s) a este correo.</div>
        </div>
        @endif

        <div class="footer">Baga San · Panel de administración</div>
    </div>
</body>
</html>