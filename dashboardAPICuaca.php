<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Cuaca</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: rgba(20, 20, 20, 0.7);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.2);
        }

        h2, h5 {
            color: #00d4ff;
        }

        table {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        thead {
            background-color: rgba(0, 212, 255, 0.2);
        }

        table td, table th {
            vertical-align: middle !important;
        }
        
        table tr td, table tr th {
            color: #ffffff;
        }

        .table-bordered td, .table-bordered th {
            border-color: rgba(255, 255, 255, 0.2);
        }

        canvas {
            background-color: #1c1c1c;
            border-radius: 10px;
            padding: 10px;
        }

        hr {
            border-color: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <h2 class="text-center mb-4">🌧️ Dashboard Cuaca - Tokyo</h2>

        <?php
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&daily=weather_code&hourly=dew_point_2m&current=rain&timezone=Asia%2FTokyo');
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        $weatherCodes = $data["daily"]["weather_code"];
        $weatherDates = $data["daily"]["time"];
        $dewPoints = $data["hourly"]["dew_point_2m"];
        $dewTimes = $data["hourly"]["time"];
        $currentRain = $data["current"]["rain"];

        $dewPoints24 = array_slice($dewPoints, 0, 24);
        $dewTimes24 = array_slice($dewTimes, 0, 24);

        echo "<script>
            var dewLabels = " . json_encode($dewTimes24) . ";
            var dewData = " . json_encode($dewPoints24) . ";
        </script>";
        ?>

        <div class="mt-4">
            <h5>📈 Grafik Titik Embun (24 Jam)</h5>
            <canvas id="dewChart" width="100%" height="40"></canvas>
        </div>

        <h5 class="mt-5">🌫️ Titik Embun per Jam</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr><th>Waktu</th><th>Titik Embun (°C)</th></tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 24; $i++) {
                    echo "<tr><td>{$dewTimes24[$i]}</td><td>{$dewPoints24[$i]}</td></tr>";
                } ?>
            </tbody>
        </table>

        <h5 class="mt-5">🌤️ Cuaca Harian (Kode)</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr><th>Tanggal</th><th>Kode Cuaca</th></tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($weatherDates); $i++) {
                    echo "<tr><td>{$weatherDates[$i]}</td><td>{$weatherCodes[$i]}</td></tr>";
                } ?>
            </tbody>
        </table>

        <!-- Tabel Curah Hujan -->
        <h5 class="mt-5">🌧️ Curah Hujan Saat Ini</h5>
        <table class="table table-bordered table-striped">
            <thead><tr><th>Hujan (mm)</th></tr></thead>
            <tbody><tr><td><?php echo $currentRain; ?></td></tr></tbody>
        </table>
    </div>
</div>

<script>
    const ctx = document.getElementById('dewChart').getContext('2d');
    const dewChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dewLabels,
            datasets: [{
                label: 'Titik Embun (°C)',
                data: dewData,
                borderColor: '#00d4ff',
                backgroundColor: 'rgba(0, 212, 255, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#ffffff'
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#ffffff' },
                    title: {
                        display: true,
                        text: 'Waktu',
                        color: '#ffffff'
                    }
                },
                y: {
                    ticks: { color: '#ffffff' },
                    title: {
                        display: true,
                        text: 'Titik Embun (°C)',
                        color: '#ffffff'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
