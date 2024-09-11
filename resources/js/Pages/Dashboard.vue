<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps(['usersByDate', 'usersByClassification', 'usersByNationality', 'usersByStatus','usersByMonth']);
const selectedDimension = ref('date');
const chartType = ref('bar'); // Default chart type
let chart = null;

const createChart = (data, labels, label, options) => {
  if (chart) {
    chart.destroy(); // Destroy the previous chart instance
  }

  const ctx = document.getElementById('chart').getContext('2d');
  chart = new Chart(ctx, {
    type: chartType.value, // Use the selected chart type
    data: {
      labels: labels,
      datasets: [{
        label: label,
        data: data,
        backgroundColor: chartType.value === 'pie' ? [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ] : 'rgba(54, 162, 235, 0.2)',
        borderColor: chartType.value === 'pie' ? [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ] : 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: options // Apply the appropriate options based on chart type
  });
};

const updateChart = () => {
  let data, labels, label, chartOptions;

  switch (selectedDimension.value) {
    case 'date':
      data = props.usersByDate.map(item => item.count);
      labels = props.usersByDate.map(item => item.date);
      label = 'Users by Creation Time';
      break;
    case 'month':
        data = props.usersByMonth.map(item => item.count);
        labels = props.usersByMonth.map(item => item.month);
        label = 'Users by Month';
        break;
    case 'classification':
      data = props.usersByClassification.map(item => item.count);
      labels = props.usersByClassification.map(item => item.classification_code);
      label = 'Users by Classification';
      break;
    case 'nationality':
      data = props.usersByNationality.map(item => item.count);
      labels = props.usersByNationality.map(item => item.nationality);
      label = 'Users by Nationality';
      break;
    case 'status':
      data = props.usersByStatus.map(item => item.count);
      labels = props.usersByStatus.map(item => item.status);
      label = 'Users by Status';
      break;
  }

  if (chartType.value === 'pie') {
    chartOptions = {
      plugins: {
        tooltip: {
          callbacks: {
            label: function (tooltipItem) {
              let total = data.reduce((acc, curr) => acc + curr, 0);
              let percentage = ((tooltipItem.raw / total) * 100).toFixed(2);
              return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
            }
          }
        }
      }
    };
  } else {
    chartOptions = {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    };
  }

  createChart(data, labels, label, chartOptions);
};

onMounted(updateChart);
watch([selectedDimension, chartType], updateChart); // Watch for changes in both chart type and dimension
</script>
<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Member Dashboard</h2>
    </template>

       <div class="items-center w-auto text-center place-items-center ">
        <div class="flex flex-col items-center justify-center h-full p-6 m-4">
            <div class="flex flex-row gap-2 text center ">
                    <select v-model="selectedDimension">
                            <option value="date">Joiners by Date</option>
                            <option value="classification">Classification</option>
                            <option value="nationality">Nationality</option>
                            <option value="status">Status</option>
                            <option value="month">Joiners by Month</option>
                        </select>


                        <select v-model="chartType">
                            <option value="bar">Bar Chart</option>
                            <option value="pie">Pie Chart</option>
                        </select>
            </div>
            <canvas id="chart" class="max-w-screen-sm max-h-72"></canvas>
        </div>



    </div>
  </AuthenticatedLayout>
</template>
