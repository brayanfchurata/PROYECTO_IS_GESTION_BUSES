<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const { props } = usePage();

const registeredDrivers = ref(props.registeredDrivers);
const trips = ref(props.trips);
const registeredBuses = ref(props.registeredBuses);

const chartData = ref({
  labels: ['Conductores', 'Viajes', 'Buses'],
  datasets: [
    {
      label: 'Cantidad',
      data: [registeredDrivers.value, trips.value, registeredBuses.value],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
    },
  ],
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                ADMINISTRADOR - Bienvenido
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="p-6 bg-white shadow-lg sm:rounded-lg">
                        <h3 class="text-xl font-semibold">Conductores Registrados</h3>
                        <p class="text-3xl font-bold">{{ registeredDrivers }}</p>
                    </div>
                    <div class="p-6 bg-white shadow-lg sm:rounded-lg">
                        <h3 class="text-xl font-semibold">Viajes</h3>
                        <p class="text-3xl font-bold">{{ trips }}</p>
                    </div>
                    <div class="p-6 bg-white shadow-lg sm:rounded-lg">
                        <h3 class="text-xl font-semibold">Buses Registrados</h3>
                        <p class="text-3xl font-bold">{{ registeredBuses }}</p>
                    </div>
                </div>

                <div class="mt-12 bg-white shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <Bar :data="chartData" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
