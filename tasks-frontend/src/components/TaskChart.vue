<template>
  <div class="h-64 flex items-center justify-center">
    <canvas ref="chartCanvas" class="max-w-full max-h-full"></canvas>
  </div>
</template>

<script setup>
import { onMounted, watch, ref, nextTick } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
  tasks: {
    type: Array,
    required: true
  }
});

const chartCanvas = ref(null);
let chart = null;

onMounted(() => {
  nextTick(() => {
    renderChart();
  });
});

watch(() => props.tasks, () => {
  nextTick(() => {
    renderChart();
  });
}, { deep: true });

function renderChart() {
  if (!chartCanvas.value) return;

  const pending = props.tasks.filter(t => t.status === 'pending').length;
  const done = props.tasks.filter(t => t.status === 'done').length;

  if (chart) {
    chart.destroy();
  }

  chart = new Chart(chartCanvas.value, {
    type: 'pie',
    data: {
      labels: ['Pending', 'Done'],
      datasets: [{
        data: [pending, done],
        backgroundColor: [
          '#ffc107',
          '#28a745'
        ],
        borderColor: [
          '#e0a800',
          '#1e7e34'
        ],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        },
        title: {
          display: true,
          text: 'Task Status Distribution'
        }
      }
    }
  });
}
</script>

