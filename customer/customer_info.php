<?php
$orderType = isset($_GET['type']) ? $_GET['type'] : 'dine_in';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enter Customer Info</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4fc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: white;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }

    h2 {
      color: #203c8a;
      margin-bottom: 20px;
      font-size: 24px;
      font-weight: 700;
    }

    input {
      width: 90%;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    button {
      width: 100%;
      padding: 14px;
      font-size: 18px;
      background-color: #203c8a;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2a4b9d;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2><?= strtoupper(str_replace('_', ' ', $orderType)) ?> - Enter Your Details</h2>
    <form action="create_order.php" method="post">
      <input type="hidden" name="order_type" value="<?= htmlspecialchars($orderType) ?>">
      <input type="text" name="customer_name" placeholder="Your Name" required>
      <input type="tel" id="phone" name="customer_phone" placeholder="Phone Number" required 
       pattern="6[0-9]{6,}" oninput="checkPhoneFormat()">
      <div id="phone-error" style="color: red; font-size: 14px; margin-top: -15px; margin-bottom: 15px;"></div>
      <button type="submit">Proceed to Menu</button>
    </form>
  </div>
  <script>
  function checkPhoneFormat() {
    const phoneInput = document.getElementById('phone');
    const errorDiv = document.getElementById('phone-error');
    const pattern = /^6[0-9]{6,}$/;

    if (!pattern.test(phoneInput.value)) {
      phoneInput.setCustomValidity("Phone number must start with 6 and contain at least 7 digits.");
      errorDiv.textContent = "*Format number is 60123456789";
    } else {
      phoneInput.setCustomValidity("");
      errorDiv.textContent = "";
    }
  }
</script>

</body>
</html>
