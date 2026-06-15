var months = ["Jan", "Mar", "May", "Jul", "Sep", "Nov"];
var expectedExpenses = [30000, 28000, 40000, 28000, 40000, 45000];
var actualExpenses = [28000, 35000, 28000, 45000, 28000, 50000];

var ctxx = document.getElementById("expenseChart").getContext("2d");

var myChart = new Chart(ctxx, {
    type: "line",
    data: {
        labels: months,
        datasets: [
            {
                label: "Total Expected Expenses",
                data: expectedExpenses,
                borderColor: "#35bfbf",
                tension: 0.4, 
            },
            {
                label: "Actual Expenses",
                data: actualExpenses,
                borderColor: "#ff6150",
                tension: 0.4, 
            },
        ],
    },
    options: {
        responsive: true, 
        maintainAspectRatio: false, 
        scales: {
            x: {
                title: {
                    display: true,
                },
                grid: {
                    display: false,
                },
            },
            y: {
                display: false,
            },
        },
        plugins: {
            tooltip: {
                enabled: true,
                mode: 'nearest',
            },
        },
    },
});
