<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RBS Monitoring Chart (2 Hourly) | Elimmas Health</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 30px 40px;
    }

    h1, h2 {
      text-align: center;
      color: #2a5c8d;
      margin: 10px 0;
    }

    .form-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 10px;
      margin-top: 15px;
    }

    .label-input {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 4px;
    }

    input, textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .scrollable-table {
      max-height: 400px;
      overflow-y: auto;
      margin-top: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #2a5c8d;
      color: white;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background: #f2f2f2;
    }

    .footer-note {
      text-align: center;
      margin-top: 30px;
      color: #555;
      font-size: 13px;
    }

    button {
      background: #2a5c8d;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 10px;
      transition: background 0.2s ease;
    }

    button:hover {
      background: #1e466d;
    }

    .add-row {
      text-align: right;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Elimmas Health</h1>
    <h2>RBS Monitoring Chart (2 Hourly)</h2>

    <div class="form-section">
      <div class="label-input">
        <label>Patient Name:</label>
        <input type="text" name="patient_name" placeholder="e.g. Baby Giftlyn">
      </div>
      <div class="label-input">
        <label>Date of Birth:</label>
        <input type="date" name="dob">
      </div>
      <div class="label-input">
        <label>Sex:</label>
        <select name="sex">
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="label-input">
        <label>Birth Weight (kg):</label>
        <input type="number" name="bwt" step="0.01" placeholder="e.g. 3.0">
      </div>
      <div class="label-input">
        <label>Date:</label>
        <input type="date" name="date">
      </div>
    </div>

    <div class="add-row">
      <button onclick="addRow()">+ Add Entry</button>
    </div>
    <form>
      <div class="scrollable-table">
      <table id="rbsTable">
        <thead>
          <tr>
            <th>Time</th>
            <th>RBS (mmol/L)</th>
            <th>Remarks / Intervention</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="time" name="time[]"></td>
            <td><input type="number" step="0.1" name="RBS[]"></td>
            <td><input type="text"  name="remarks[]" placeholder="e.g. fed, IV glucose..."></td>
          </tr>
        </tbody>
      </table>
      <div class="add-row">
        <button type="submit">Save</button>
      </div>
    </div>
    </form>
    

    <div class="footer-note">
      Elimmas Health — RBS Monitoring Chart | Confidential
    </div>
  </div>

  <script>
    function addRow() {
      const table = document.getElementById('rbsTable').getElementsByTagName('tbody')[0];
      const newRow = table.insertRow();
      newRow.innerHTML = `
        <td><input type="time"></td>
        <td><input type="number" step="0.1"></td>
        <td><input type="text" placeholder="Remarks / Intervention"></td>
      `;
    }
  </script>
</body>
</html>
