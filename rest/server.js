const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const WebSocket = require('ws'); 
const axios = require('axios');

const app = express();
const port = 3000;
app.use(cors());
app.use(express.json());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'u-cafe',
  port: 3301
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
    SELECT o.order_id, o.order_number, o.order_date, oi.item_name, oi.quantity
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
          no: row.order_number,
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

  const updateSql = "UPDATE orders SET status = ? WHERE order_id = ?";
  db.query(updateSql, [new_status, order_id], (err, result) => {
    if (err) return res.status(500).json({ error: 'Update failed' });

    wss.broadcast({
      action: 'status_updated',
      order_id: order_id,
      new_status: new_status
    });

    if (new_status !== 'ready') {
      return res.json({ message: 'Status updated successfully' });
    }

    const fetchSql = "SELECT customer_phone, order_number FROM orders WHERE order_id = ?";
    db.query(fetchSql, [order_id], (err, results) => {
      if (err || results.length === 0) {
        return res.json({ message: 'Status updated, but failed to retrieve customer info' });
      }

      const { customer_phone, order_number } = results[0];
      const message = `Hi! Your order #${order_number} is ready. Please collect it at the counter.`;

      axios.get('https://rest.moceanapi.com/rest/2/sms', {
        params: {
          'mocean-api-key': '96f4b6a2',
          'mocean-api-secret': 'b713019a',
          'mocean-from': 'KIOSK',
          'mocean-to': customer_phone,
          'mocean-text': message
        }
      })
      .then(response => {
        console.log(`✅ SMS sent to ${customer_phone}:`, response.data);
        res.json({ message: 'Status updated and SMS sent successfully' });
      })
      .catch(error => {
        console.error(`❌ Failed to send SMS to ${customer_phone}:`, error.response?.data || error.message);
        res.json({ message: 'Status updated but failed to send SMS' });
      });
    });
  });
});


app.listen(port, () => {
  console.log(`✅ REST API running at http://localhost:${port}`);
});


wss.on('connection', (ws) => {
  console.log('🔌 WebSocket client connected');
});

console.log('📡 WebSocket server running on ws://localhost:8080');
