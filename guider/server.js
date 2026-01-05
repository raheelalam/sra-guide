const express = require('express');
const fs = require('fs');
const cors = require('cors');
const app = express();

app.use(cors());
app.use(express.json());

const DATA_FILE = './db.json'; // <--- Double check this filename!

app.get('/tutorials', (req, res) => {
  const data = fs.readFileSync(DATA_FILE, 'utf8');
  res.json(JSON.parse(data));
});

app.put('/tutorials_update', (req, res) => {
  try {
    // This writes the ENTIRE array sent from the frontend to the file
    fs.writeFileSync(DATA_FILE, JSON.stringify(req.body, null, 2), 'utf8');
    console.log("File updated successfully");
    res.status(200).send({ message: "Saved successfully!" });
  } catch (err) {
    console.error("Save Error:", err);
    res.status(500).send({ message: "Error saving file" });
  }
});

app.listen(3000, () => console.log('Server running on http://localhost:3000'));