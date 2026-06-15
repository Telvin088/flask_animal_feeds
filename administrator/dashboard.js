var data = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  datasets: [
      {
          label: 'Clients',
          data: [10, 20, 15, 25, 30, 18],
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.4,  
      },
      {
          label: 'Expenses',
          data: [5, 10, 5, 15, 25, 10],
          borderColor: 'rgb(255, 99, 132)',
          tension: 0.4,
      },
      {
          label: 'Products',
          data: [12, 18, 22, 28, 24, 32],
          borderColor: 'rgb(54, 162, 235)',
          tension: 0.4,
      }
  ]
};

var config = {
  type: 'line',
  data: data,
  options: {
      plugins: {
          tooltip: {
              callbacks: {
                  label: function (context) {
                      return context.dataset.label + ': ' + context.parsed.y;
                  }
              }
          }
      }
  }
};

var ctx = document.getElementById('line-chart').getContext('2d');
new Chart(ctx, config);