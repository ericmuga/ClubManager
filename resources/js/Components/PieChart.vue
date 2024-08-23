<template>
  <div>
    <canvas ref="pieChartCanvas"></canvas>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Chart, PieController, ArcElement, Tooltip, Legend } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

// Register the necessary components with Chart.js
Chart.register(PieController, ArcElement, Tooltip, Legend, ChartDataLabels);

const props = defineProps({
  data: Object
});

const pieChartCanvas = ref(null);

onMounted(() => {
  new Chart(pieChartCanvas.value, {
    type: 'pie',
    data: props.data,
    options: {
      plugins: {
        tooltip: {
          callbacks: {
            label: function (tooltipItem) {
              const dataset = tooltipItem.dataset;
              const total = dataset.data.reduce((prevValue, currentValue) => prevValue + currentValue, 0);
              const currentValue = dataset.data[tooltipItem.dataIndex];
              const percentage = Math.round((currentValue / total) * 100);
              return `${tooltipItem.label}: ${currentValue} (${percentage}%)`;
            },
          },
        },
        datalabels: {
          formatter: (value, ctx) => {
            const total = ctx.chart.data.datasets[0].data.reduce((prevValue, currentValue) => prevValue + currentValue, 0);
            const percentage = Math.round((value / total) * 100);
            return `${percentage}%`;
          },
          color: '#fff',
        },
      },
    },
  });
});
</script>
