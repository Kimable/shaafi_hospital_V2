<!DOCTYPE html>
<html>

<head>
  <title>Health Record</title>
  <style>
    body {
      font-family: 'Helvetica', 'Arial', sans-serif;
      color: #333;
      line-height: 1.6;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
    }

    .header h1 {
      color: #00a551;
    }

    .header h2 {
      font-size: 25px;
      color: #ec1c24;
      margin-bottom: 10px;
    }

    .header .logo {
      width: 100px;
    }

    .header p {
      font-size: 14px;
      color: #7f8c8d;
    }

    .section {
      margin-bottom: 30px;
    }

    .section h2 {
      font-size: 20px;
      color: #34495e;
      border-bottom: 2px solid #34495e;
      padding-bottom: 5px;
      margin-bottom: 15px;
    }

    .info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .info p {
      margin: 0;
      font-size: 14px;
    }

    .info p strong {
      color: #2c3e50;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 12px;
      color: #7f8c8d;
    }
  </style>
</head>

<body>
  <div class="header">
    {{-- <img class='logo' src="https://shaafihospital.so/img/shaafi-logo-text-white.png" alt=""> --}}
    <h1>Shaafi Hospital Health Record</h1>
    <h2>{{ $healthRecord->title }} for {{$user->first_name }}</h2>
  </div>

  <div class="section">
    <h2>Patient Information</h2>
    <div class="info">
      <p><strong>Patient Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
      <p><strong>Date of Record:</strong> {{ $healthRecord->date }}</p>
    </div>
  </div>

  <div class="section">
    <h2>Details</h2>
    <div class="info">
      <p><strong>Medical Condition:</strong> {{ $healthRecord->title }}</p>
      <p> <strong>Summary: </strong> {{ $healthRecord->description }}</p>
      <p><strong>Category:</strong> {{ $healthRecord->type }}</p>
    </div>
  </div>

  <div class="section">
    <h2>Doctor Information</h2>
    <div class="info">
      <p><strong>Doctor Name:</strong> Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</p>
      <p><strong>Doctor Email:</strong> {{ $doctor->email }}</p>
      <p><strong>Specialty:</strong> {{ $doc_specialty }}</p>
    </div>
  </div>

  <div class="footer">
    <p>Generated on: {{ now()->format('F j, Y') }}</p>
    <p>This document was generated automatically. Please contact your healthcare provider for any questions.</p>
  </div>
</body>

</html>