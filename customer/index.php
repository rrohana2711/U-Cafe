<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Welcome to Student Café</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: 'Poppins', sans-serif;
      overflow: hidden;
      cursor: pointer;
    }

    .background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:url("mainutem.jpg");
      background-size: cover;
      filter: blur(5px);
      z-index: -2;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .content {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
      color: #ecf0f1;
      z-index: 1;
      padding: 30px;
    }

    h1 {
      font-size: 3.2em;
      margin-bottom: 20px;
      color:  rgb(44, 86, 128);
      font-weight: 700;
    }

    p {
      font-size: 1.6em;
      color:rgb(92, 92, 92);
      font-weight: 400;
    }

    .welcome-box {
    background: rgb(255, 255, 255); /* light glass effect */
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    padding: 40px 50px;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.77);
    transition: transform 0.3s ease;
  }

  .welcome-box:hover {
    transform: scale(1.02);
  }

  </style>
</head>
<body onclick="window.location.href='order-type.php'">
  <div class="background"></div>
  <div class="overlay"></div>

  <div class="content">
  <div class="welcome-box">
    <img src="img/utem.png" alt="Universiti Teknikal Malaysia Melaka" style="width: 180px; height: auto; margin-bottom: 20px;">
    <h1>Welcome to U-Café</h1>
    <p>Touch anywhere to start</p>
  </div>
</div>

</body>
</html>
