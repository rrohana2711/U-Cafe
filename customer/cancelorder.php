<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Cancelled</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f8; /* Soft blue-gray background */
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      color: #2c3e50; /* Deep blue-gray text */
    }

    .cancel-box {
      background-color: #ffffff;
      border: 2px solid #c9d6e3;
      border-radius: 15px;
      padding: 50px 40px;
      max-width: 400px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 28px;
      margin-bottom: 15px;
      color: #c0392b; /* Red tone for cancellation */
    }

    p {
      font-size: 18px;
      margin-bottom: 30px;
      color: #5d6d7e;
    }

    .home-btn {
      padding: 12px 28px;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      background-color: #3b5998; /* Theme blue */
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
      font-size: 14px;
      color: #7f8c8d;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="cancel-box">
    <h1>Order Cancelled</h1>
    <p>Your order has been successfully cancelled. We hope to serve you again soon!</p>
    <a href="index.php" class="home-btn">Back to Menu</a>
    <div class="redirect-msg">Redirecting to menu in 3 seconds...</div>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = "index.php"; 
    }, 3000);
  </script>

</body>
</html>
