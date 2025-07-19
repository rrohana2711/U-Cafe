const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const WebSocket = require('ws'); 

const app = express();
const port = 3000;
app.use(cors());
app.use(express.json());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'u-cafe'
});


const wss = new WebSocket.Server({ port: 8080 });

wss.broadcast = (data) => {
  wss.clients.forEach(client => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(JSON.stringify(data));
    }
  });
};


app.get('/orders', (req, res) => {
  const status = req.query.status;

  const sql = `
    SELECT o.order_id, o.order_date, oi.item_name, oi.quantity
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.status = ?
    ORDER BY o.order_id DESC
  `;

  db.query(sql, [status], (err, results) => {
    if (err) return res.status(500).json({ error: 'Database error' });

    const orders = {};
    results.forEach(row => {
      if (!orders[row.order_id]) {
        orders[row.order_id] = {
          id: row.order_id,
          time: new Date(row.order_date).toLocaleTimeString(),
          items: [],
          status: status
        };
      }
      orders[row.order_id].items.push(`${row.item_name} x${row.quantity}`);
    });

    res.json(Object.values(orders));
  });
});


app.post('/update_status', (req, res) => {
  const { order_id, new_status } = req.body;

  const sql = "UPDATE orders SET status = ? WHERE order_id = ?";
  db.query(sql, [new_status, order_id], (err, result) => {
    if (err) return res.status(500).json({ error: 'Update failed' });

    wss.broadcast({
    action: 'status_updated',
    order_id: order_id,
    new_status: new_status
  });

    res.json({ message: 'Status updated successfully' });
  });
});

app.listen(port, () => {
  console.log(`✅ REST API running at http://localhost:${port}`);
});


wss.on('connection', (ws) => {
  console.log('🔌 WebSocket client connected');
});

console.log('📡 WebSocket server running on ws://localhost:8080');
