<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Log Error</title>
</head>
<body style="margin:0; padding:24px; background-color:#f1f5f9; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px; margin:0 auto; background-color:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e2e8f0;">
        <tr>
            <td style="background-color:#dc2626; padding:20px 24px; color:#ffffff;">
                <div style="font-size:12px; font-weight:700; letter-spacing:0.6px; text-transform:uppercase; opacity:0.9;">
                    {{ $alertData['app_name'] ?? 'CalonASN' }} &bull; {{ strtoupper($alertData['environment'] ?? 'production') }}
                </div>
                <h1 style="margin:6px 0 0; font-size:20px; line-height:1.3; font-weight:700; color:#ffffff;">
                    Terjadi Log {{ strtoupper($alertData['level'] ?? 'ERROR') }}
                </h1>
            </td>
        </tr>

        <tr>
            <td style="padding:20px 24px;">
                <div style="background-color:#fef2f2; border-left:4px solid #dc2626; padding:12px 14px; border-radius:6px; margin-bottom:20px; font-size:13px; color:#7f1d1d;">
                    Notifikasi ini hanya dikirim <strong>1x per hari</strong> untuk error yang sama. Silakan cek Log Viewer untuk investigasi detailnya.
                </div>

                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-bottom:20px; font-size:13px;">
                    <tr>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#64748b; width:130px; font-weight:600;">Waktu</td>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#0f172a;">{{ $alertData['timestamp'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#64748b; font-weight:600;">URL / Proses</td>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#0f172a; word-break:break-all;">
                            <strong>{{ $alertData['method'] ?? 'CLI' }}</strong> {{ $alertData['url'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#64748b; font-weight:600;">User</td>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#0f172a;">{{ $alertData['user_info'] ?? 'Guest' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#64748b; font-weight:600;">IP Address</td>
                        <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#0f172a;">{{ $alertData['ip'] ?? '-' }}</td>
                    </tr>
                    @if (!empty($alertData['location']))
                        <tr>
                            <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#64748b; font-weight:600;">Lokasi Kode</td>
                            <td style="padding:8px 10px; border-bottom:1px solid #e2e8f0; color:#0f172a; word-break:break-all;">{{ $alertData['location'] }}</td>
                        </tr>
                    @endif
                </table>

                <div style="margin-bottom:18px;">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#475569; margin-bottom:6px;">Pesan Error</div>
                    <div style="background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px 14px; font-family:Consolas, Monaco, monospace; font-size:13px; color:#b91c1c; white-space:pre-wrap; word-break:break-word;">{{ $alertData['message'] ?? '-' }}</div>
                </div>

                @if (!empty($alertData['trace']))
                    <div style="margin-bottom:22px;">
                        <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#475569; margin-bottom:6px;">Ringkasan Stack Trace / Context</div>
                        <pre style="margin:0; background-color:#0f172a; color:#e2e8f0; border-radius:8px; padding:14px; font-family:Consolas, Monaco, monospace; font-size:11px; line-height:1.5; overflow-x:auto; white-space:pre-wrap; word-break:break-word;">{{ $alertData['trace'] }}</pre>
                    </div>
                @endif

                @if (!empty($alertData['log_viewer_url']))
                    <div style="text-align:center; padding-top:4px;">
                        <a href="{{ $alertData['log_viewer_url'] }}" style="display:inline-block; background-color:#2563eb; color:#ffffff; text-decoration:none; font-weight:600; font-size:14px; padding:11px 22px; border-radius:8px;">
                            Buka Log Viewer
                        </a>
                    </div>
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
