<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperación de contraseña - LagoEmpleo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    /* RESET */
    body, table, td, a {
      margin:0;
      padding:0;
      text-decoration:none;
      border-collapse:collapse;
    }

    body, html {
      height:100%;
      margin:0;
      padding:0;
      background:#f4f7fb;
      font-family:Arial,Helvetica,sans-serif;
    }

    .main{
      display:flex;
      align-items:center;
      justify-content:center;
      height:100%;
      padding:20px;
      background:#f4f7fb;
    }

    .content{
      width:90%;
      max-width:600px;
      background:#ffffff;
      border-radius:12px;
      overflow:hidden;
      box-shadow:0 6px 18px rgba(0,0,0,0.08);
      animation: fadeIn 1s ease-in-out;
      margin:auto;
    }

    .header{
      padding:20px;
      display:flex;
      align-items:center;
      justify-content:flex-start;
    }

    .logo{
      width:64px;
      height:64px;
      margin-right:12px;
      transform:scale(0.95);
      transition: transform 0.4s ease;
    }

    .logo:hover{
      transform:scale(1.05) rotate(3deg);
    }

    .title{
      font-size:20px;
      color:#2563eb;
      font-weight:bold;
    }

    .body{
      padding:20px;
      border-top:1px solid #f1f5f9;
    }

    .body h2{
      margin:0 0 10px 0;
      font-size:20px;
      color:#0b1220;
      animation: slideDown 0.8s ease;
    }

    .body p{
      margin:0 0 16px 0;
      font-size:14px;
      color:#6b7280;
    }

    .password-box{
      background:#f8fafc;
      padding:14px;
      border:1px solid #eef2ff;
      display:inline-block;
      margin-bottom:18px;
      box-shadow:inset 0 0 6px rgba(37,99,235,0.15);
      animation: pulse 1.8s infinite;
    }

    .password-box .label{
      font-size:13px;
      color:#6b7280;
      margin-bottom:6px;
    }

    .password-box .code{
      font-weight:700;
      font-size:18px;
      letter-spacing:2px;
      color:#111827;
    }

    .btn{
      display:inline-block;
      background:#2563eb;
      color:#fff;
      padding:12px 20px;
      border-radius:8px;
      font-weight:600;
      transition:all 0.3s ease;
      box-shadow:0 4px 12px rgba(37,99,235,0.3);
    }

    .btn:hover{
      background:#1d4ed8;
      transform:translateY(-2px);
      box-shadow:0 6px 16px rgba(37,99,235,0.4);
    }

    .footer{
      padding:14px;
      text-align:center;
      font-size:12px;
      color:#9ca3af;
    }

    @keyframes fadeIn {
      from {opacity:0; transform:translateY(20px);}
      to {opacity:1; transform:translateY(0);}
    }

    @keyframes slideDown {
      from {opacity:0; transform:translateY(-20px);}
      to {opacity:1; transform:translateY(0);}
    }

    @keyframes pulse {
      0% { box-shadow:inset 0 0 6px rgba(37,99,235,0.15); }
      50% { box-shadow:inset 0 0 12px rgba(37,99,235,0.25); }
      100% { box-shadow:inset 0 0 6px rgba(37,99,235,0.15); }
    }

    @media screen and (max-width: 640px) {
      .content {
        width:95%;
      }
      .body h2{
        font-size:18px;
      }
      .password-box .code{
        font-size:16px;
      }
      .btn{
        width:100%;
        text-align:center;
      }
    }
  </style>
</head>

<body>
  <div class="main">
    <div class="content">
      <!-- Header -->
      <div class="header">
        <img src="{{ $message->embed($logo) }}" alt="LagoEmpleo" class="logo">
        <span class="title">LagoEmpleo</span>
      </div>

      <!-- Body -->
      <div class="body">
        <h2>Hemos generado una contraseña temporal</h2>
        <p>Utiliza esta contraseña para acceder a tu cuenta y recuerda cambiarla después de iniciar sesión.</p>

        <div class="password-box">
          <div class="label">Tu contraseña temporal:</div>
          <div class="code">{{ $password }}</div>
        </div>

        <a href="{{ url('/') }}" class="btn">Iniciar sesión</a>
      </div>

      <!-- Footer -->
      <div class="footer">
        © LagoEmpleo {{ date('Y') }}
      </div>
    </div>
  </div>
</body>
</html>
