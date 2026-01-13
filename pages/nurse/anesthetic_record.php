<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Anaesthetic Record Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f9f9f9;
    }
    h2 {
      text-align: center;
      margin-bottom: 10px;
      color: #2a5c8d;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.08);
    }
    .section {
      margin-bottom: 20px;
    }
    label {
      display: inline-block;
      width: 150px;
      font-weight: bold;
      vertical-align: top;
      margin-top: 8px;
    }
    input, textarea, select {
      width: calc(100% - 10px);
      padding: 6px;
      margin-bottom: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    textarea { resize: vertical; }
    hr { border: none; border-top: 1px solid #e0e0e0; margin: 18px 0; }

    /* RBS-style table (applied to vitals) */
    .table-actions {
      display: flex;
      justify-content: flex-end;
      margin-top: 6px;
      gap: 10px;
    }
    .add-btn {
      background: #2a5c8d;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
    }
    .add-btn:hover { background: #1f466d; }

    .scrollable-table {
      border: 1px solid #ccc;
      border-radius: 6px;
      max-height: 360px;
      overflow-y: auto;
      margin-top: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #bbb;
      padding: 8px;
      text-align: center;
      vertical-align: middle;
    }
    th {
      background: #e8eef6;
      font-weight: 700;
      color: #12385e;
    }
    tr:nth-child(even) td { background: #fbfcfd; }

    .footer-note {
      text-align: center;
      margin-top: 20px;
      color: #666;
      font-size: 13px;
    }

    /* small screens tweaks */
    @media (max-width: 720px) {
      label { display: block; width: 100%; margin-top: 10px; }
      input, textarea, select { width: 100%; }
    }
  </style>
</head>
<body>
  <h2>ANAESTHETIC RECORD FORM</h2>

  <form id="anaesForm">
    <!-- PATIENT INFO -->
    <div class="section">
      <label>Patient Name:</label><input type="text" name="patient_name"><br>
      <label>Age:</label><input type="text" name="age">
      <label>Sex:</label><input type="text" name="sex"><br>
      <label>Ward:</label><input type="text" name="ward">
      <label>Hosp No.:</label><input type="text" name="hosp_no"><br>
      <label>Surgeon:</label><input type="text" name="surgeon"><br>
      <label>Anaesthetist:</label><input type="text" name="anaesthetist"><br>
      <label>Assistants:</label><input type="text" name="assistants"><br>
    </div>

    <div class="section">
      <label>Date:</label><input type="date" name="date">
      <label>Emergency / Elective:</label>
      <select name="emergency_elective">
        <option>Emergency</option>
        <option>Elective</option>
      </select><br>
      <label>Weight (kg):</label><input type="number" step="0.1" name="weight">
    </div>

    <hr>

    <!-- PRE-OP ASSESSMENT -->
    <div class="section">
      <h3 style="margin:0 0 10px 0; color:#2a5c8d;">PRE-ASSESSMENT</h3>
      <label>Special features / previous anaesthetic:</label><input type="text" name="special_features"><br>
      <label>ASA Status:</label><input type="text" name="asa_status"><br>
      <label>Current medications:</label><input type="text" name="current_medications"><br>
      <label>BP on admission:</label><input type="text" name="bp_admission"><br>
    </div>

    <hr>

    <!-- ANAESTHESIA DETAILS -->
    <div class="section">
      <h3 style="margin:0 0 10px 0; color:#2a5c8d;">ANAESTHESIA DETAILS</h3>
      <label>Start Time:</label><input type="time" name="start_time">
      <label>Finish Time:</label><input type="time" name="finish_time"><br>

      <label>Premedication:</label><input type="text" name="premedication"><br>
      <label>Operation:</label><input type="text" name="operation"><br>
      <label>Diagnosis:</label><input type="text" name="diagnosis"><br>
      <label>Anesthetic technique:</label><input type="text" name="technique"><br>
      <label>IV fluids in theatre:</label><input type="text" name="iv_fluids"><br>
      <label>Anesthetic drugs & doses:</label><textarea name="drugs_doses" rows="3"></textarea><br>
      <label>Other drugs used:</label><textarea name="other_drugs" rows="2"></textarea><br>
    </div>

    <hr>

    <!-- REPLACED PARAGRAPH: INTRAOPERATIVE MONITORING (RBS TABLE STYLE) -->
    <div class="section">
      <h3 style="margin:0 0 10px 0; color:#2a5c8d;">INTRAOPERATIVE MONITORING (Vitals)</h3>

      <div class="table-actions">
        <button type="button" class="add-btn" onclick="addVitalsRow()">+ Add Entry</button>
      </div>

      <div class="scrollable-table" aria-live="polite">
        <table id="vitalsTable" role="table">
          <thead>
            <tr>
              <th style="width:12%;">Time</th>
              <th style="width:14%;">BP (mmHg)</th>
              <th style="width:10%;">Pulse (bpm)</th>
              <th style="width:12%;">Resp. Rate (/min)</th>
              <th style="width:10%;">SpO₂ (%)</th>
              <th style="width:10%;">Temp (°C)</th>
              <th style="width:12%;">Urine Output (ml)</th>
              <th style="width:12%;">IV Fluids (ml)</th>
              <th style="width:16%;">Drugs Given / Events</th>
              <th style="width:18%;">Remarks / Intervention</th>
            </tr>
          </thead>
          <tbody>
            <!-- one editable default row to start -->
            <tr>
              <td><input type="time" name="v_time[]"></td>
              <td><input type="text" name="v_bp[]" placeholder="e.g. 110/70"></td>
              <td><input type="number" name="v_pulse[]"></td>
              <td><input type="number" name="v_resp[]"></td>
              <td><input type="number" name="v_spo2[]"></td>
              <td><input type="number" step="0.1" name="v_temp[]"></td>
              <td><input type="number" name="v_urine[]"></td>
              <td><input type="number" name="v_iv[]"></td>
              <td><input type="text" name="v_drugs[]"></td>
              <td><input type="text" name="v_remarks[]"></td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <p style="font-size:13px;color:#555;margin-top:8px;">
        Use the <strong>+ Add Entry</strong> button to add additional time rows. Each row represents a timepoint (e.g. every 5–15 minutes).
      </p>
    </div>

    <hr>

    <!-- POST-OP -->
    <div class="section">
      <h3 style="margin:0 0 10px 0; color:#2a5c8d;">IMMEDIATE POST-OP CONDITION</h3>
      <label>B.P:</label><input type="text" name="post_bp">
      <label>Pulse:</label><input type="text" name="post_pulse"><br>
      <label>Resp. Rate:</label><input type="text" name="post_resp">
      <label>Extubated:</label>
      <select name="extubated"><option>Yes</option><option>No</option></select><br>
      <label>Consciousness:</label>
      <select name="consciousness">
        <option>Fully Conscious</option>
        <option>Semi-conscious</option>
        <option>Unconscious</option>
      </select><br>
      <label>Post Instructions:</label><textarea name="post_instructions" rows="3"></textarea><br>
    </div>

    <div style="text-align:center;margin-top:12px;">
      <button type="submit" style="background:#2a5c8d;color:#fff;border:none;padding:10px 16px;border-radius:6px;cursor:pointer;">
        Submit
      </button>
    </div>

    <div class="footer-note">
      Elimmas Health — Anaesthetic Record | Confidential
    </div>
  </form>

  <script>
    function addVitalsRow() {
      const tbody = document.querySelector('#vitalsTable tbody');
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="time" name="v_time[]"></td>
        <td><input type="text" name="v_bp[]" placeholder="e.g. 110/70"></td>
        <td><input type="number" name="v_pulse[]"></td>
        <td><input type="number" name="v_resp[]"></td>
        <td><input type="number" name="v_spo2[]"></td>
        <td><input type="number" step="0.1" name="v_temp[]"></td>
        <td><input type="number" name="v_urine[]"></td>
        <td><input type="number" name="v_iv[]"></td>
        <td><input type="text" name="v_drugs[]"></td>
        <td><input type="text" name="v_remarks[]"></td>
      `;
      tbody.appendChild(row);
      // scroll to newly added row
      row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // simple form submit handler (prevents default for demo)
    document.getElementById('anaesForm').addEventListener('submit', function (e) {
      e.preventDefault();
      // collect form data here or submit to your backend
      alert('Form submitted (demo) — hook this up to your backend to save records.');
    });
  </script>
</body>
</html>
