<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Café Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f8fb;
      color: #2c3e50;
    }

    .container {
      display: grid;
      grid-template-columns: 250px 1fr;
      height: 100vh;
    }

    .sidebar {
      background: #e6ebf1;
      padding: 30px 20px;
      border-right: 1px solid #c0d0e0;
    }

    .sidebar h3 {
      font-size: 22px;
      color: #203c8a;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
    }

    .sidebar button {
      display: block;
      width: 100%;
      background: #3b5998;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 12px;
      margin-bottom: 12px;
      font-size: 15px;
      font-weight: 500;
      transition: 0.3s;
      cursor: pointer;
    }

    .sidebar button.active,
    .sidebar button:hover {
      background: #2c3e50;
    }

    .main {
      display: flex;
      flex-direction: column;
      background: #f5f8fb;
      padding-bottom: 80px;
    }

    .menu-header {
      padding: 24px;
      background: #dfe8f1;
      border-bottom: 1px solid #c0d0e0;
    }

    .menu-header h2 {
      font-size: 28px;
      font-weight: 700;
      color: #2c3e50;
    }

    .menu-grid {
      flex: 1;
      padding: 24px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      overflow-y: auto;
    }

    .menu-item {
      background: #ffffff;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.06);
      text-align: center;
      transition: 0.3s;
    }

    .menu-item:hover {
      transform: translateY(-5px);
    }

    .menu-item img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 12px;
    }

    .menu-item h3 {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #34495e;
    }

    .menu-item p {
      font-size: 14px;
      color: #566573;
    }

    .quantity-control {
      margin-top: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
    }

    .quantity-control button {
      width: 34px;
      height: 34px;
      font-size: 18px;
      border: none;
      border-radius: 50%;
      background: #203c8a;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }

    .quantity-control button:hover {
      background: #2c3e50;
    }

    .qty {
      font-size: 18px;
      color: #2c3e50;
    }

    .cart-bar {
    position: fixed;
    bottom: 0;
    left: 250px; /* matches sidebar width */
    right: 0;
    padding: 16px 24px;
    background: #fff;
    border-top: 1px solid #ddd0c4;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05);
  }
  @media (max-width: 768px) {
  .cart-bar {
    left: 0;
  }
}


    .cart-bar span {
      font-size: 16px;
      color: #2c3e50;
    }

    .cart-bar button {
      padding: 10px 18px;
      font-size: 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
    }

    .cancel-btn {
      background: #e74c3c;
      color: #fff;
      margin-right: 10px;
    }

    .cancel-btn:hover {
      background: #c0392b;
    }

    .view-btn {
      background: #203c8a;
      color: #fff;
    }

    .view-btn:hover {
      background: #296288;
    }

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #9cb4cc;
      border-radius: 10px;
    }

    #orderListModal {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fef3e7;
  border: 2px solid #e0cfc1;
  border-radius: 16px;
  padding: 32px 40px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  width: 600px; /* increased width */
  max-height: 80vh;
  overflow-y: auto;
  z-index: 999;
}

#orderListContent {
  list-style: none;
  padding: 0;
  text-align: left;
  margin-bottom: 20px;
  color: #6f4e37;
  font-size: 16px;
}

#orderListContent li {
  padding: 8px 0;
  border-bottom: 1px dashed #d0b49f;
}

#orderListModal h3 {
  font-size: 24px;
  margin-bottom: 20px;
  color: #3e2723;
  text-align: center;
}

#orderListModal button {
  font-size: 16px;
}

  </style>
</head>
<body>


<div class="container">
  <div class="sidebar">
    <h3>Categories</h3>
    <button onclick="filterMenu('all')">All</button>
    <button onclick="filterMenu('set')">Set Meals</button>
    <button onclick="filterMenu('masakan')">Masakan Panas</button>
    <button onclick="filterMenu('kuah')">Makanan Berkuah</button>
    <button onclick="filterMenu('western')">Western</button>
    <button onclick="filterMenu('side')">Side Dishes</button>
    <button onclick="filterMenu('drink')">Drinks</button>
    <button onclick="filterMenu('juice')">Juices</button>
  </div>

  <div class="main">
    <div class="menu-header">
      <h2>U-Café Menu</h2>
    </div>

    <div class="menu-grid" id="menuGrid">

  <!-- Drinks -->
  <div class="menu-item" data-name="Teh O Ais" data-price="1.50" data-category="drink">
    <img src="img/tehoais.png" alt="Teh O Ais">
    <h3>Teh O Ais</h3><p>RM1.50</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Matcha Ais" data-price="3.00" data-category="drink">
    <img src="img/matcha.png" alt="Matcha Ais">
    <h3>Matcha Ais</h3><p>RM3.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Kopi O" data-price="1.00" data-category="drink">
    <img src="img/kopio.png" alt="Kopi O">
    <h3>Kopi O</h3><p>RM1.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Teh O" data-price="1.00" data-category="drink">
    <img src="img/teho.png" alt="Teh 0">
    <h3>Teh O</h3><p>RM1.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Teh Tarik" data-price="1.00" data-category="drink">
    <img src="img/tehtarik.png" alt="Teh Tarik">
    <h3>Teh Tarik</h3><p>RM1.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Milo" data-price="2.50" data-category="drink">
    <img src="img/milopanas.png" alt="Milo">
    <h3>Milo</h3><p>RM2.50</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <!-- Add 5 more drink items similarly -->

  <!-- Juices -->
  <div class="menu-item" data-name="Apple Juice" data-price="2.20" data-category="juice">
    <img src="img/applejuice.png" alt="Apple Juice">
    <h3>Apple Juice</h3><p>RM2.20</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Orange Juice" data-price="2.50" data-category="juice">
    <img src="img/orangejuice.png" alt="Orange Juice">
    <h3>Orange Juice</h3><p>RM2.50</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Watermelon Juice" data-price="3.00" data-category="juice">
    <img src="img/tembikaijuice.png" alt="Watermelon Juice">
    <h3>Watermelon Juice</h3><p>RM3.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <!-- Add 8 more juice items -->

  <!-- Set Meals -->
  <div class="menu-item" data-name="Nasi Ayam" data-price="6.00" data-category="set">
  <img src="img/nasi ayam.png" alt="Nasi Ayam">
  <h3>Nasi Ayam</h3><p>RM6.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Nasi Lemak" data-price="2.00" data-category="set">
  <img src="img/nasi lemak.png" alt="Nasi Lemak">
  <h3>Nasi Lemak</h3><p>RM2.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Nasi Bujang" data-price="4.00" data-category="set">
  <img src="img/nasi bujang.png" alt="Nasi Bujang">
  <h3>Nasi Bujang</h3><p>RM4.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Nasi Geprek" data-price="6.00" data-category="set">
  <img src="img/Nasi Geprek.png" alt="Nasi Geprek">
  <h3>Nasi Geprek</h3><p>RM6.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Nasi Lemak Ayam" data-price="6.00" data-category="set">
  <img src="img/nasi lemak ayam.png" alt="Nasi Lemak Ayam">
  <h3>Nasi Lemak Ayam</h3><p>RM6.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Nasi Tomato" data-price="6.00" data-category="set">
  <img src="img/nasi Tomato.png" alt="Nasi Tomato">
  <h3>Nasi Tomato</h3><p>RM6.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
  <!-- Add 9 more set meals -->

  <!-- Masakan Panas -->
  <div class="menu-item" data-name="Nasi Goreng" data-price="4.50" data-category="masakan">
    <img src="img/nasi goreng.png" alt="Nasi Goreng">
    <h3>Nasi Goreng</h3><p>RM4.50</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Mee Goreng" data-price="4.00" data-category="masakan">
  <img src="img/mee goreng.png" alt="Mee Goreng">
  <h3>Mee Goreng</h3><p>RM4.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Kuey Teow Goreng" data-price="4.00" data-category="masakan">
  <img src="img/kuey teow goreng.png" alt="Kuey Teow Goreng">
  <h3>Kuey Teow Goreng</h3><p>RM4.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Maggie Goreng" data-price="4.00" data-category="masakan">
  <img src="img/Maggi goreng.png" alt="Maggie Goreng">
  <h3>Maggie Goreng</h3><p>RM4.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
  <!-- Add 9 more masakan panas -->

  <!-- Berkuah -->

  <div class="menu-item" data-name="Mi Kari" data-price="5.00" data-category="kuah">
  <img src="img/mi kari.png" alt="Mi Kari">
  <h3>Mi Kari</h3><p>RM5.00</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Laksa" data-price="4.50" data-category="kuah">
  <img src="img/laksa.png" alt="Laksa">
  <h3>Laksa</h3><p>RM4.50</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>
<div class="menu-item" data-name="Tomyam" data-price="5.50" data-category="kuah">
  <img src="img/tomyam.png" alt="Tomyam">
  <h3>Tomyam</h3><p>RM5.50</p>
  <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
</div>


<!-- Add 9 more makanan berkuah -->

  <!-- Western -->
  <div class="menu-item" data-name="Chicken Chop" data-price="8.90" data-category="western">
    <img src="img/chicken chop.png" alt="Chicken Chop">
    <h3>Chicken Chop</h3><p>RM8.90</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Spaghetti Bolognese" data-price="5.00" data-category="western">
    <img src="img/bolognese.png" alt="Spaghetti Bolognese">
    <h3>Spaghetti Bolognese</h3><p>RM5.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Spaghetti Carbonara" data-price="5.00" data-category="western">
    <img src="img/cabonara.png" alt="Spaghetti Carbonara">
    <h3>Spaghetti Carbonara</h3><p>RM5.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Spaghetti Aglio Olio" data-price="5.00" data-category="western">
    <img src="img/aglio.png" alt="Spaghetti Aglio Olio">
    <h3>Spaghetti Aglio Olio</h3><p>RM5.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <!-- Add 9 more western items -->

  <!-- Side Dishes -->
  <div class="menu-item" data-name="French Fries" data-price="3.00" data-category="side">
    <img src="img/fries.png" alt="French Fries">
    <h3>French Fries</h3><p>RM3.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Nuggets" data-price="0.80" data-category="side">
    <img src="img/Nugget.png" alt="Nuggets">
    <h3>Nuggets</h3><p>RM0.80</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <div class="menu-item" data-name="Takoyaki" data-price="5.00" data-category="side">
    <img src="img/Takoyaki.png" alt="Takoyaki">
    <h3>Takoyaki</h3><p>RM5.00</p>
    <div class="quantity-control"><button onclick="decreaseQty(this)">−</button><span class="qty">0</span><button onclick="increaseQty(this)">+</button></div>
  </div>
  <!-- Add 9 more side dishes -->

</div>

    <div class="cart-bar">
      <span id="cartCount">0 items in cart</span>
      <div>
        <button class="cancel-btn" onclick="clearCart()">Reset Order</button>
        <button class="view-btn" onclick="showOrderList()">View order list</button>
      </div>
    </div>
    <!-- Order List Modal -->
<div id="orderListModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#fef3e7; border:2px solid #e0cfc1; border-radius:16px; padding:32px 40px; box-shadow:0 10px 30px rgba(0,0,0,0.2); width:600px; max-height:80vh; overflow-y:auto; z-index:999;">
  <h3 style="margin-bottom: 15px; color:#3e2723;">🧾 Your Order</h3>
  <ul id="orderListContent" style="list-style:none; padding:0; text-align:left; margin-bottom: 12px; color:#6f4e37;"></ul>

  <div style="margin-top: 10px; font-weight:bold; color:#4e342e;">
    Total: RM <span id="modalTotalPrice">0.00</span>
  </div>

  <div style="margin-top: 20px; display: flex; justify-content: space-between;">
    <button onclick="closeOrderList()" style="padding:10px 16px; background:#e53935; color:#fff; border:none; border-radius:10px; cursor:pointer;">Close</button>
    <button onclick="goToPayment()" style="padding:10px 16px; background:#203c8a; color:#fff; border:none; border-radius:10px; cursor:pointer;">Proceed</button>
  </div>
</div>

<!-- Overlay -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:998;" onclick="closeOrderList()"></div>

  </div>
</div>

<script>
   let cart = JSON.parse(localStorage.getItem('cart')) || [];


    function showOrderList() {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  const listContainer = document.getElementById('orderListContent');
  const totalEl = document.getElementById('modalTotalPrice');
  listContainer.innerHTML = '';

  let total = 0;

  if (cart.length === 0) {
    listContainer.innerHTML = '<li>No items in your cart.</li>';
  } else {
    cart.forEach((item, index) => {
      const li = document.createElement('li');
      li.style.display = "flex";
      li.style.justifyContent = "space-between";
      li.style.alignItems = "center";
      li.style.marginBottom = "6px";

      const itemText = document.createElement('span');
      itemText.textContent = `${item.name} x${item.quantity} — RM ${(item.price * item.quantity).toFixed(2)}`;

      const cancelBtn = document.createElement('button');
      cancelBtn.textContent = '❌';
      cancelBtn.style.background = 'transparent';
      cancelBtn.style.border = 'none';
      cancelBtn.style.cursor = 'pointer';
      cancelBtn.style.color = '#e53935';
      cancelBtn.style.fontSize = '18px';
      cancelBtn.title = 'Remove item';
      cancelBtn.onclick = () => {
        removeItemFromCart(item.name);
        showOrderList(); // Refresh modal after deletion
      };

      li.appendChild(itemText);
      li.appendChild(cancelBtn);
      listContainer.appendChild(li);

      total += item.price * item.quantity;
    });
  }

  totalEl.textContent = total.toFixed(2);
  document.getElementById('orderListModal').style.display = 'block';
  document.getElementById('overlay').style.display = 'block';
}


function closeOrderList() {
  document.getElementById('orderListModal').style.display = 'none';
  document.getElementById('overlay').style.display = 'none';
}

function goToPayment() {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];


  if (cart.length === 0) {
    alert("Your cart is empty.");
    return;
  }

fetch('save_order.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(cart)
})
.then(response => response.text())  // <--- temporarily use .text()
.then(text => {
  console.log("Raw response:", text);
  const data = JSON.parse(text); // parse manually
  if (data.success) {
    localStorage.removeItem('cart');
    window.location.href = 'payment.php';
  } else {
    alert("Failed to save order: " + data.message);
  }
})
.catch(error => {
  console.error("Fetch error:", error);
  alert("An error occurred.");
});
}

  function filterMenu(category) {
      document.querySelectorAll('.menu-item').forEach(item => {
        item.style.display = (category === 'all' || item.dataset.category === category) ? 'block' : 'none';
      });
      document.querySelectorAll('.sidebar button').forEach(btn => btn.classList.remove('active'));
      const activeBtn = Array.from(document.querySelectorAll('.sidebar button')).find(btn => btn.textContent.toLowerCase().includes(category));
      if (activeBtn) activeBtn.classList.add('active');
    }

  function increaseQty(button) {
    const menuItem = button.closest('.menu-item');
    const qtySpan = menuItem.querySelector('.qty');
    let qty = parseInt(qtySpan.textContent);
    qty++;
    qtySpan.textContent = qty;
    updateCart(menuItem, qty);
  }

  function decreaseQty(button) {
    const menuItem = button.closest('.menu-item');
    const qtySpan = menuItem.querySelector('.qty');
    let qty = parseInt(qtySpan.textContent);
    if (qty > 0) {
      qty--;
      qtySpan.textContent = qty;
      updateCart(menuItem, qty);
    }
  }

  function updateCart(menuItem, qty) {
    const name = menuItem.dataset.name;
    const price = parseFloat(menuItem.dataset.price);
    const existing = cart.find(item => item.name === name);

    if (existing) {
      if (qty === 0) {
        cart = cart.filter(item => item.name !== name);
      } else {
        existing.quantity = qty;
      }
    } else if (qty > 0) {
      cart.push({ name, price, quantity: qty });
    }

    updateCartBar();
  }

  function updateCartBar() {
    let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById("cartCount").textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  function removeItemFromCart(itemName) {
  cart = cart.filter(item => item.name !== itemName);
  localStorage.setItem('cart', JSON.stringify(cart));
  document.querySelectorAll('.menu-item').forEach(item => {
    if (item.dataset.name === itemName) {
      item.querySelector('.qty').textContent = '0';
    }
  });
  updateCartBar();
}


  function clearCart() {
    cart = [];
    document.querySelectorAll('.qty').forEach(qty => qty.textContent = '0');
    updateCartBar();
  }

  filterMenu('all');

  const socket = new WebSocket("ws://localhost:8080");

socket.onopen = () => {
  console.log("✅ WebSocket connected to server");
};

socket.onmessage = (event) => {
  const data = JSON.parse(event.data);
  if (data.action === 'status_updated') {
  const orderId = data.order_id || 'Unknown';
  const status = data.new_status || 'Unknown';
  alert(`📢 Order #${orderId} status is now "${status}"!`);
}
};

socket.onerror = (error) => {
  console.error("WebSocket error:", error);
};


  
</script> 

</body>
</html>
