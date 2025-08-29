<!DOCTYPE html>
<html lang="id">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Sertifikat</title>
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    .certificate {
      position: relative;
      width: 100%;
      height: 100%;
      z-index: 10;
    }

    /* Nama Peserta */
    .student-name {
      position: absolute;
      top: 38%; /* dinaikkan sedikit */
      left: 50%;
      transform: translateX(-50%);
      font-size: 48px;
      font-weight: 700;
      color: #111;
      text-align: center;
      letter-spacing: 2px;
      text-transform: uppercase;
    }

    /* Judul Kursus */
    .course-title {
    position: absolute;
    top: 52%; /* diturunkan sedikit */
    left: 50%;
    transform: translateX(-50%);
    font-size: 30px; /* diperbesar sedikit */
    font-weight: 900; /* ditebalkan */
    font-style: italic;
    color: #1e3a8a;
    text-align: center;
    letter-spacing: 1px;
  }

    /* Bagian bawah (Tanggal & Instruktur) */
    .section {
      text-align: center;
      font-family: 'Poppins', sans-serif;
    }

    .section .name {
      font-size: 18px;
      color: #111;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .section .line {
      margin: 8px auto 4px;
      width: 180px;
      border-bottom: 2px solid #000;
    }

    .section .label {
      font-size: 14px;
      color: #444;
      font-style: italic;
      letter-spacing: 0.5px;
    }

    .date-section {
      position: absolute;
      bottom: 18%;
      left: 15%;
    }

    .instructor-section {
      position: absolute;
      bottom: 18%;
      right: 15%;
    }

    /* Nomor Sertifikat */
    .certificate-number {
      position: absolute;
      bottom: 6%;
      right: 6%;
      font-size: 14px;
      color: #555;
      font-style: italic;
      letter-spacing: 0.5px;
    }
  </style>
</head>
<body>
  <div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; text-align: center; z-index: -1;">
    <img src="{{ $backgroundImage }}" style="width: 100%; height: 100%;">
  </div>

  <div class="certificate">
    <div class="student-name">{{ $studentName }}</div>
    <div class="course-title">{{ $courseTitle }}</div>

    <!-- Tanggal -->
    <div class="section date-section">
      <div class="name">{{ $completionDate }}</div>
      <div class="line"></div>
      <div class="label">Tanggal</div>
    </div>

    <!-- Instruktur -->
    <div class="section instructor-section">
      <div class="name">{{ $instructorName }}</div>
      <div class="line"></div>
      <div class="label">Instruktur</div>
    </div>

    <div class="certificate-number">No: {{ $certificateNumber }}</div>
  </div>
</body>
</html>
