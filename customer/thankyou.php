<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thank You</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f8; /* Light blue-gray */
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      color: #2c3e50; /* Navy-gray text */
    }

    .thank-box {
      background-color: #ffffff;
      border: 2px solid #c9d6e3;
      border-radius: 16px;
      padding: 50px 40px;
      max-width: 400px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 32px;
      margin-bottom: 15px;
      color: #3b5998;
    }

    p {
      font-size: 18px;
      margin-bottom: 30px;
      color: #5d6d7e;
    }

    .home-btn {
      padding: 14px 30px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      background-color: #3b5998; /* Primary blue */
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      font-weight: 600;
    }

    .home-btn:hover {
      background-color: #2c3e70;
    }

    .redirect-msg {
      margin-top: 15px;
      font-size: 14px;
      color: #607d8b;
    }
  </style>
</head>
<body>

  <div class="thank-box">
    <h1>Thank You!</h1>
    <p>Your order has been processed. Have a great day!</p>
    <a href="index.php" class="home-btn">Back to Home</a>
    <div class="redirect-msg">You will be redirected to the home page in 5 seconds...</div>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = "index.php";  
    }, 5000);
  </script>

</body>
</html>
