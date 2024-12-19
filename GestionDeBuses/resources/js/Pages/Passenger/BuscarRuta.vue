<script setup>
import AuthenticatedLayoutPasajero from '@/Layouts/AuthenticatedLayoutPasajero.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const codigo = ref('');
const error = ref('');
const successMessage = ref('');
const viaje = ref(null);

const buscarViaje = async () => {
    error.value = '';
    successMessage.value = '';
    viaje.value = null;

    try {
        await Inertia.post(route('passenger.buscarRuta'), { codigo: codigo.value }, {
            preserveScroll: true,
            onSuccess: (page) => {
                viaje.value = page.props.viaje || null;
                successMessage.value = 'Viaje encontrado correctamente.';
            },
            onError: (errors) => {
                error.value = errors.codigo || 'Ocurrió un error al buscar el viaje.';
            },
        });
    } catch (err) {
        error.value = 'Error inesperado. Intenta nuevamente.';
        console.error(err);
    }
};
</script>

<template>
    <Head title="DashboarPasajero" />

    <AuthenticatedLayoutPasajero>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Buscar Ruta
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold mb-4">Buscar Viaje</h2>
                        <form @submit.prevent="buscarViaje">
                            <label for="codigo" class="block text-sm font-medium text-gray-700">Código del Viaje:</label>
                            <input 
                                id="codigo" 
                                type="text" 
                                v-model="codigo" 
                                required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            />
                            <button 
                                type="submit" 
                                class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-500">
                                Buscar
                            </button>
                        </form>

                        <!-- Mostrar mensajes de éxito o error -->
                        <div v-if="error" class="mt-4 text-red-600 font-semibold">
                            {{ error }}
                        </div>
                        <div v-if="successMessage" class="mt-4 text-green-600 font-semibold">
                            {{ successMessage }}
                        </div>

                        <!-- Mostrar detalles del viaje si se encuentra -->
                        <div v-if="viaje" class="mt-6">
                            <h3 class="text-lg font-semibold">Detalles del Viaje</h3>
                            <p><strong>Código:</strong> {{ viaje.codigo }}</p>
                            <p><strong>Destino:</strong> {{ viaje.destino }}</p>
                            <p><strong>Fecha:</strong> {{ viaje.fecha }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutPasajero>
</template>
