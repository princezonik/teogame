<!DOCTYPE html>
<html>
    <head>
        <title>DPS → TTK Calculator</title>
        <style>
            body {
                font-family: sans-serif;
                padding: 40px;
                max-width: 500px;
                margin: auto;
            }
            input {
                padding: 10px;
                font-size: 16px;
                margin-bottom: 20px;
                width: 100%;
                box-sizing: border-box;
            }
            label {
                font-weight: bold;
            }
            .result {
                margin-top: 20px;
                font-size: 18px;
            }
        </style>
    </head>
    <body>
        <h1>DPS → TTK Calculator</h1>

        <div>
            <label for="dps">Damage per Second (DPS):</label>
            <input type="number" step="any" id="dps" placeholder="Enter weapon DPS">
        </div>

        <div>
            <label for="hp">Enemy Hitpoints (HP):</label>
            <input type="number" step="any" id="hp" placeholder="Enter enemy HP">
        </div>

        <div class="result" id="ttkResult"></div>

        <script>
        const dpsInput = document.getElementById('dps');
        const hpInput = document.getElementById('hp');
        const resultDiv = document.getElementById('ttkResult');

        function calculateTTK() {
            const dps = parseFloat(dpsInput.value);
            const hp = parseFloat(hpInput.value);

            if (!isNaN(dps) && !isNaN(hp) && dps > 0) {
                const ttk = hp / dps;
                resultDiv.innerHTML = `🕒 Time to Kill: <strong>${ttk.toFixed(2)}</strong> seconds`;
            } else {
                resultDiv.innerHTML = '';
            }
        }

        dpsInput.addEventListener('input', calculateTTK);
        hpInput.addEventListener('input', calculateTTK);
        </script>
    </body>
</html>
