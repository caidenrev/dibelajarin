<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            text-align: center;
            color: #1a1a1a;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .certificate-container {
            position: relative;
            width: 100%;
            height: 100vh;
            padding: 40px;
            box-sizing: border-box;
            background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);
        }

        .border-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 30px solid transparent;
            background: 
                linear-gradient(45deg, #3b82f6 25%, transparent 25%) -5px 0,
                linear-gradient(-45deg, #3b82f6 25%, transparent 25%) -5px 0,
                linear-gradient(45deg, transparent 75%, #3b82f6 75%),
                linear-gradient(-45deg, transparent 75%, #3b82f6 75%);
            background-size: 10px 10px;
            background-position: 0 0, 0 5px, 5px -5px, -5px 0px;
            border-image: linear-gradient(45deg, #3b82f6, #1e40af) 1;
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.9);
            margin: 20px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .certificate-title {
            font-size: 52px;
            font-weight: 700;
            color: #1e40af;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .student-name {
            font-size: 42px;
            font-weight: 600;
            color: #1e3a8a;
            margin: 30px 0;
            padding: 10px 40px;
            display: inline-block;
            border-bottom: 4px solid #3b82f6;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .course-title {
            font-size: 32px;
            font-weight: 500;
            color: #2563eb;
            margin: 25px 0;
            font-style: italic;
        }

        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            padding: 0 100px;
        }

        .signature-container {
            flex: 1;
            margin: 0 20px;
            text-align: center;
        }

        .signature-line {
            width: 100%;
            max-width: 200px;
            border-bottom: 2px solid #3b82f6;
            margin: 10px auto;
        }

        .signature-title {
            font-size: 18px;
            color: #4b5563;
            margin-top: 5px;
            font-weight: 500;
        }

        .certificate-number {
            position: absolute;
            bottom: 20px;
            right: 40px;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="border-pattern"></div>
        <div class="content">
            <div class="logo">LMS KITA</div>
            <h1 class="certificate-title">Sertifikat Kelulusan</h1>
            <p style="font-size: 20px; color: #4b5563; margin: 15px 0;">Dengan ini menyatakan bahwa:</p>
            <div class="student-name">{{ $studentName }}</div>
            <p style="font-size: 20px; color: #4b5563;">telah berhasil menyelesaikan kursus</p>
            <div class="course-title">"{{ $courseTitle }}"</div>
            
            <div class="footer">
                <div class="signature-container">
                    <p>{{ $completionDate }}</p>
                    <div class="signature-line"></div>
                    <p class="signature-title">Tanggal</p>
                </div>
                
                <div class="signature-container">
                    @if($instructorSignature)
                        <img src="{{ $instructorSignature }}" alt="Tanda Tangan Instruktur" style="max-width: 150px; margin-bottom: 10px;">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div class="signature-line"></div>
                    <p class="signature-title">{{ $instructorName ?? 'Instruktur' }}</p>
                </div>
            </div>

            <div class="certificate-number">
                No. Sertifikat: {{ $certificateNumber ?? 'CERT-' . time() }}
            </div>
        </div>
    </div>
</body>

</html>
