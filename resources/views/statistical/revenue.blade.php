<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Revenue Chart</h1>
<canvas id="revenueChart"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDate = '2024-01-01'; // Example start date
        const endDate = '2024-12-31'; // Example end date

        fetch(`statistical/revenue-data?start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.daily_revenue.map(item => item.date);
                const revenues = data.daily_revenue.map(item => item.total);

                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line', // Use 'bar' for bar chart
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Revenue',
                            data: revenues,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>

