<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi OTP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 28px;">UMKM<span style="font-weight: normal;">Pedia</span></h1>
    </div>
    
    <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; border: 1px solid #ddd; border-top: none;">
        <h2 style="color: #8B4513; margin-top: 0;">Kode Verifikasi OTP</h2>
        
        <p>Halo,</p>
        
        <p>Berikut adalah kode OTP untuk verifikasi pendaftaran akun Anda di UMKMPedia:</p>
        
        <div style="background: #8B4513; color: white; font-size: 32px; font-weight: bold; letter-spacing: 8px; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0;">
            {{ $otpCode }}
        </div>
        
        <p style="color: #666; font-size: 14px;">
            <strong>Penting:</strong>
            <ul style="color: #666; font-size: 14px;">
                <li>Kode ini berlaku selama <strong>10 menit</strong></li>
                <li>Jangan bagikan kode ini kepada siapapun</li>
                <li>Jika Anda tidak melakukan pendaftaran, abaikan email ini</li>
            </ul>
        </p>
        
        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
        
        <p style="color: #999; font-size: 12px; text-align: center;">
            &copy; {{ date('Y') }} UMKMPedia. Mendukung UMKM Indonesia.
        </p>
    </div>
</body>
</html>
