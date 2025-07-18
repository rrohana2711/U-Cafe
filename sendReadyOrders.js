const mysql = require('mysql2/promise');
const axios = require('axios');

const sendSMS = async (recipient, message) => {
  try {
    const response = await axios.get('https://rest.moceanapi.com/rest/2/sms', {
      params: {
        'mocean-api-key': '96f4b6a2',
        'mocean-api-secret': 'b713019a',
        'mocean-from': 'KIOSK',
        'mocean-to': recipient,
        'mocean-text': message
      }
    });

    console.log(`✅ SMS sent to ${recipient}. Response:`, response.data);
  } catch (error) {
    console.error(`❌ Failed to send SMS to ${recipient}:`, error.response?.data || error.message);
  }
};

const sendReadyOrderMessages = async () => {
  try {
    const connection = await mysql.createConnection({
      host: 'localhost',
      user: 'root',          
      password: '',          
      database: 'u-cafe',
      port: 3301
    });

    const [rows] = await connection.execute(
      "SELECT customer_phone, order_number FROM orders WHERE status = 'ready'"
    );

    for (const row of rows) {
      const message = `Hi! Your order #${row.order_number} is ready. Please collect it at the counter.`;
      await sendSMS(row.customer_phone, message);
    }

    await connection.end();
  } catch (err) {
      console.error('❌ Database error:', err.message);
  }
};

// Run it
sendReadyOrderMessages();
