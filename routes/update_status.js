const express = require('express');
const mysql = require('mysql2/promise');
const axios = require('axios');

const router = express.Router();

// POST /update_status
router.post('/update_status', async (req, res) => {
  const { order_id, new_status } = req.body;

  if (!order_id || !new_status) {
    return res.status(400).json({ message: 'Invalid data' });
  }

  try {
    const conn = await mysql.createConnection({
      host: 'localhost',
      user: 'root',
      password: '',
      database: 'u-cafe',
      port: 3301
    });

    // Update status
    const [updateResult] = await conn.execute(
      'UPDATE orders SET status = ? WHERE order_id = ?',
      [new_status, order_id]
    );

    if (new_status === 'ready') {
      const [rows] = await conn.execute(
        'SELECT customer_phone, order_number FROM orders WHERE order_id = ?',
        [order_id]
      );

      if (rows.length > 0) {
        const { customer_phone, order_number } = rows[0];
        const message = `Hi! Your order #${order_number} is ready. Please collect it at the counter.`;

        const smsResponse = await axios.get('https://rest.moceanapi.com/rest/2/sms', {
          params: {
            'mocean-api-key': '96f4b6a2',
            'mocean-api-secret': 'b713019a',
            'mocean-from': 'KIOSK',
            'mocean-to': customer_phone,
            'mocean-text': message
          }
        });

        await conn.end();
        return res.json({ message: 'Status updated and SMS sent successfully', smsResponse: smsResponse.data });
      } else {
        await conn.end();
        return res.status(404).json({ message: 'Customer not found' });
      }
    }

    await conn.end();
    return res.json({ message: 'Status updated successfully' });

  } catch (err) {
    console.error('❌ Error:', err.message);
    return res.status(500).json({ message: 'Internal server error', error: err.message });
  }
});

module.exports = router;
