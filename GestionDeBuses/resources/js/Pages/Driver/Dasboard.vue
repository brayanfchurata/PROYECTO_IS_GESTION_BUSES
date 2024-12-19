<script setup>
import AuthenticatedLayoutConductor from '@/Layouts/AuthenticatedLayoutConductor.vue';
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

const viajesCount = ref(props.viajesCount || 0);
const newNorma = ref('');
const normas = ref([
    'Tener los papeles en orden',
    'Tener brevete',
    'Dormir bien',
    'No tomar bebidas alcohólicas',
]);

const addNorma = () => {
  if (newNorma.value.trim()) {
    normas.value.push(newNorma.value);
    newNorma.value = '';
  }
};

const deleteNorma = (index) => {
  normas.value.splice(index, 1);
};

const viajesData = ref({
  labels: ['Viajes Asignados'],
  datasets: [
    {
      label: 'Cantidad',
      data: [viajesCount.value],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
    },
  ],
});
</script>

<template>
    <Head title="Conductor" />

    <AuthenticatedLayoutConductor>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                CONDUCTOR
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>

                <div class="mt-6 bg-white shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold">Gráfico de Viajes Asignados</h3>
                        <Bar :data="viajesData" />
                    </div>
                </div>

                <div class="mt-6 bg-white shadow-lg sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold">Normas de Convivencia</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div v-for="(norma, index) in normas" :key="index" class="p-4 bg-gray-100 rounded-lg shadow hover:bg-gray-200 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                                <div class="flex items-center justify-between">
                                    <span>{{ norma }}</span>
                                    <button @click="deleteNorma(index)" class="px-2 py-1 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex mt-4 space-x-2">
                            <input
                                v-model="newNorma"
                                type="text"
                                placeholder="Agregar nueva norma"
                                class="flex-1 px-4 py-2 border rounded-lg"
                            />
                            <button @click="addNorma" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutConductor>
</template>
