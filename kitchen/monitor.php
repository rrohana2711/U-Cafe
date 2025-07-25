<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>U-Cafe Order Monitor</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fc;
      color: #203C8A;
      padding: 20px;
    }
    h1 {
      text-align: center;
      font-size: 36px;
      margin-bottom: 30px;
      color: #203C8A;
    }
    .section-container {
      display: flex;
      justify-content: space-between;
      gap: 40px;
    }
    .order-section {
      flex: 1;
      background: #eaf0ff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(32, 60, 138, 0.1);
    }
    .section-title {
      text-align: center;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #203C8A;
    }
    .order-number {
      text-align: center;
      font-size: 48px;
      font-weight: bold;
      margin: 20px 0;
      color: #2e3d61;
    }
  </style>
</head>
<body>

  <div style="text-align: center; margin-bottom: 10px;">
    <img src="utem.png" alt="UTeM Logo" style="max-width: 200px;" />
  </div>
  <h1>Now Serving</h1>

  <div class="section-container">
    <div class="order-section" id="preparing-section">
      <div class="section-title">Preparing</div>
    </div>

    <div class="order-section" id="ready-section">
      <div class="section-title">Ready</div>
    </div>
  </div>

  <script>
    const apiBase = 'http://localhost:3000';
    const ws = new WebSocket('ws://localhost:8080');

    ws.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if (data.action === 'status_updated') {
        loadMonitor();
      }
    };

    async function fetchOrders(status) {
      const response = await fetch(`${apiBase}/orders?status=${status}`);
      return await response.json();
    }

    function renderOrderNumbers(sectionId, orders) {
      const section = document.getElementById(sectionId);
      section.innerHTML = `<div class="section-title">${capitalize(sectionId.split('-')[0])}</div>`;

      if (orders.length === 0) {
        section.innerHTML += `<div class="order-number"></div>`;
      } else {
        orders.forEach(order => {
          section.innerHTML += `<div class="order-number">${order.no}</div>`;
        });
      }
    }

    function capitalize(word) {
      return word.charAt(0).toUpperCase() + word.slice(1);
    }

    async function loadMonitor() {
      const preparingOrders = await fetchOrders('preparing');
      const readyOrders = await fetchOrders('ready');

      renderOrderNumbers('preparing-section', preparingOrders);
      renderOrderNumbers('ready-section', readyOrders);
    }

    loadMonitor();
  </script>

</body>
</html>