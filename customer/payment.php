<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Confirmation</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f8; /* Light Blue Gray */
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      color: #2c3e50; /* Navy Gray */
    }

    .confirmation-box {
      background-color: #ffffff;
      border: 2px solid #c9d6e3;
      border-radius: 15px;
      padding: 40px 60px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    h1 {
      margin-bottom: 10px;
      font-size: 28px;
      font-weight: 600;
    }

    p {
      font-size: 18px;
      margin-bottom: 25px;
      color: #607d8b;
    }

    .btn-confirm {
      padding: 14px 36px;
      font-size: 18px;
      border: none;
      border-radius: 12px;
      background-color: #3b5998; /* U-Café Navy */
      color: white;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
      margin: 8px;
    }

    .btn-confirm:hover {
      background-color: #2c3e50; /* Darker Navy */
    }
  </style>
</head>
<body>

  <div class="confirmation-box">
    <h1>Are you done with your order?</h1>
    <p>Please confirm to proceed to receipt and pay at counter</p>
    <form action="update_status.php" method="post" style="display: inline;">
      <input type="hidden" name="status" value="pending">
      <button class="btn-confirm" type="submit">Done</button>
    </form>
    <form action="update_status.php" method="post" style="display: inline;">
      <input type="hidden" name="status" value="cancelled">
      <button class="btn-confirm" type="submit">Cancel</button>
    </form>
  </div>

  <script>
    function confirmOrder() {
      window.location.href = 'receipt.php';
    }

    function cancelOrder() {
      window.location.href = 'cancelorder.php';
    }
  </script>

</body>
</html>
