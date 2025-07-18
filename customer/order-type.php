<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Select Order Type</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color:#f0f4f8;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #2c3e50; /* Navy Gray */
    }
    .order-type-container {
      text-align: center;
      background-color: #ffffff;
      border: 2px solid #c9d6e3;
      border-radius: 15px;
      padding: 40px 60px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    h1 {
      margin-bottom: 30px;
      font-size: 2.8em;
      color: #203c8a;
      font-weight: 700;
    }
    .btn {
      padding: 18px 36px;
      font-size: 22px;
      margin: 10px;
      cursor: pointer;
      border: none;
      border-radius: 10px;
      color: white;
      transition: 0.3s ease;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      font-weight: 600;
    }
    .btn.dine-in { background-color: #131f41; }
    .btn.dine-in:hover { background-color: #20374d; }
    .btn.takeaway { background-color: rgb(48, 70, 94); }
    .btn.takeaway:hover { background-color: #4a5968; }
  </style>
</head>
<body>
  <div class="order-type-container">
    <h1>Please choose order type</h1>
    <form action="customer_info.php" method="get">
      <input type="hidden" name="type" value="dine_in">
      <button class="btn dine-in" type="submit">Dine In</button>
    </form>
    <form action="customer_info.php" method="get">
      <input type="hidden" name="type" value="take_away">
      <button class="btn takeaway" type="submit">Takeaway</button>
    </form>
  </div>
</body>
</html>
