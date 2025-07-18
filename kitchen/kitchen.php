<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>U-Cafe Kitchen Dashboard</title>
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fc;
      padding: 20px;
    }
    h1, h2 {
      text-align: center;
      color: #203C8A;
      margin-bottom: 0;
    }
    h2 { margin-bottom: 30px; }

    .section-container {
      display: flex;
      justify-content: space-between;
      gap: 20px;
    }
    .order-section {
      flex: 1;
      padding: 15px;
      background: #eaf0ff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(32, 60, 138, 0.05);
    }
    .section-title {
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      color: #203C8A;
      margin-bottom: 15px;
    }
    .order-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(32, 60, 138, 0.1);
      padding: 15px;
      margin-bottom: 20px;
      position: relative;
      transition: all 0.3s ease;
    }
    .order-header {
      font-weight: bold;
      font-size: 18px;
      color: #203C8A;
      margin-bottom: 10px;
      text-align: center;
    }
    .order-detail { margin: 6px 0; color: #2e3d61; }
    .item-line {
      display: flex;
      justify-content: space-between;
      font-size: 15px;
      font-weight: 600;
    }
    .menu-list {
      margin: 8px 0;
      padding-left: 20px;
    }
    .menu-list li {
      margin-bottom: 5px;
      font-size: 17px;
    }
    .status-line {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }
    button {
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      color: white;
      cursor: pointer;
    }
    .button-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

    .cook-btn { background-color: #4e73df; }
    .cook-btn:hover { background-color: #1b2f6e; }
    .done-btn { background-color: #f6c23e; }
    .done-btn:hover { background-color: #8a6917ff; }
    .final-done-btn { background-color: #1cc88a; }
    .final-done-btn:hover { background-color: #25673e; }
    .status { font-weight: bold; color: #203C8A; }

    .fullscreen-icon {
      position: absolute;
      bottom: 12px;
      right: 12px;
      width: 26px;
      height: 26px;
      background: rgba(32, 60, 138, 0.05);
      border-radius: 6px;
      padding: 4px;
      cursor: pointer;
    }
    .status-pending {
  padding: 2px 6px;
  border-radius: 4px;
  color: red;
  font-weight: 600;
}

.status-preparing {
  color: #e6b800; /* yellowish */
  padding: 2px 6px;
  border-radius: 4px;
  font-weight: 600;
}

.status-ready {
  color: green;
  padding: 2px 6px;
  border-radius: 4px;
  font-weight: 600;
}


  </style>
</head>
<body>

  <div style="text-align: center; margin-bottom: 10px;">
    <img src="utem.png" alt="UTeM Logo" style="max-width: 200px;" />
  </div>
  <h1>U-Cafe Ordering System</h1>
  <h2>Kitchen Dashboard</h2>

  <div class="section-container">
    <div class="order-section" id="pending-section">
      <div class="section-title">Pending</div>
    </div>

    <div class="order-section" id="preparing-section">
      <div class="section-title">Preparing</div>
    </div>

    <div class="order-section" id="ready-section">
      <div class="section-title">Ready</div>
    </div>
  </div>

  <div id="fullscreenOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div class="fullscreen-content" style="background:white; padding:20px; border-radius:10px; max-width:500px; text-align:center; position:relative;">
      <button onclick="closeFullscreen()" class="close-btn" style="position:absolute; top:10px; right:10px; font-size:20px; cursor:pointer;">×</button>
      <div id="fullscreenDetails"></div>
    </div>
  </div>

  <script>
    const apiBase = 'http://localhost:3000'; // Node.js REST API
    const ws = new WebSocket('ws://localhost:8080'); // Node.js WebSocket

    ws.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if (data.action === 'status_updated') {
        loadOrders();
      }
    };

    async function fetchOrders(status) {
  const response = await fetch(`${apiBase}/orders?status=${status}`);
  return await response.json();
}

function renderOrders(sectionId, orders, nextStatus, buttonClass, buttonText) {
  const section = document.getElementById(sectionId);
  section.innerHTML = `<div class="section-title">${statusCapital(sectionId)}</div>`;

  if (orders.length === 0) {
    section.innerHTML += `<p>No orders.</p>`;
    return;
  }

  orders.forEach(order => {
    console.log("Order object:", order); // DEBUG

    const orderCard = document.createElement('div');
    orderCard.className = 'order-card';

    const itemsList = order.items.map(item => `<li>${item}</li>`).join('');

    orderCard.innerHTML = `
    <div class="order-header">Order ID: ${order.id}</div>
      <div class="order-header">Order No: ${order.no}</div>
      <div class="order-detail">
        <div class="item-line">
          <span><strong>Items:</strong></span>
          <span>${order.time}</span>
        </div>
        <ul class="menu-list">${itemsList}</ul>
      </div>
      <div class="order-detail status-line">
        <strong>Status:</strong>
        <span class="status status-${order.status}">${order.status}</span>
      </div>
      <div class="button-wrapper">
        <button class="${buttonClass}" onclick="updateStatus(${order.id}, '${nextStatus}')">${buttonText}</button>
      </div>
      <img src="preview.png" class="fullscreen-icon" onclick="openFullscreen(this)" />
    `;

    section.appendChild(orderCard);
  });
  
}


    function statusCapital(sectionId) {
      if (sectionId.includes('pending')) return 'Pending';
      if (sectionId.includes('preparing')) return 'Preparing';
      if (sectionId.includes('ready')) return 'Ready';
      return '';
    }

    async function updateStatus(orderId, newStatus) {
      const response = await fetch(`${apiBase}/update_status`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order_id: orderId, new_status: newStatus })
      });

      if (response.ok) {
        loadOrders();
        if (newStatus === 'ready') {
      alert('Pickup notification has been sent to the customer via message.');
    }
      } else {
        alert('Failed to update order status.');
      }
    }

    async function loadOrders() {
      const pendingOrders = await fetchOrders('pending');
      const preparingOrders = await fetchOrders('preparing');
      const readyOrders = await fetchOrders('ready');

      renderOrders('pending-section', pendingOrders, 'preparing', 'cook-btn', 'Preparing');
      renderOrders('preparing-section', preparingOrders, 'ready', 'done-btn', 'Ready');
      renderOrders('ready-section', readyOrders, 'completed', 'final-done-btn', 'Done');
    }

    function openFullscreen(icon) {
      const card = icon.closest('.order-card');
      const header = card.querySelector(".order-header").innerHTML;
      const itemBlock = card.querySelector(".order-detail").innerHTML;
      const status = card.querySelector(".status").outerHTML;

      const html = `
        <h2>${header}</h2>
        <div>${itemBlock}</div>
        <p><strong>Status:</strong> ${status}</p>
      `;

      document.getElementById("fullscreenDetails").innerHTML = html;
      document.getElementById("fullscreenOverlay").style.display = "flex";
    }

    function closeFullscreen() {
      document.getElementById("fullscreenOverlay").style.display = "none";
    }

    loadOrders();
  </script>

</body>
</html>