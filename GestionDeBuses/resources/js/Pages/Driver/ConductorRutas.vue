<script setup>
import { ref } from 'vue';
import AuthenticatedLayoutConductor from '@/Layouts/AuthenticatedLayoutConductor.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

// Props recibidas desde Inertia
defineProps({
    viajes: Array, // Datos de los viajes
    buses: Array,  // Datos de los buses
    conductor: Object, // Información del conductor
});

// Método para actualizar el estado de un viaje
const updateEstado = async (viajeId, estado) => {
    try {
        // Realizamos la solicitud para cambiar el estado del viaje
        await Inertia.patch(route('driver.cambiarEstado', viajeId), { estado });

        // Actualizamos el estado del viaje en el array de 'viajes' después de la actualización
        const viaje = viajes.find(v => v.id === viajeId);
        if (viaje) {
            viaje.estado = estado;
            // Si el estado es "terminado", eliminamos el viaje de la lista
            if (estado === 'terminado') {
                // Eliminamos el viaje del array local de viajes
                const index = viajes.indexOf(viaje);
                if (index !== -1) {
                    viajes.splice(index, 1);
                }
            }
        }
    } catch (error) {
        console.error('Error al actualizar el estado del viaje:', error);
    }
};

// Método para cambiar el estado en el frontend (localmente)
const toggleEstado = (viaje) => {
    // Determinamos el nuevo estado del viaje
    const nuevoEstado = viaje.estado === 'terminado' ? 'en_proceso' : 'terminado';
    
    // Actualizamos el estado en el backend y en el frontend
    updateEstado(viaje.id, nuevoEstado);
};
</script>

<template>
    <Head title="Viajes" />

    <AuthenticatedLayoutConductor>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                Viajes del Conductor
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Mostrar viajes -->
                        <div v-if="viajes.length">
                            <h3 class="font-bold text-lg mb-4">Lista de Viajes</h3>
                            <div v-for="viaje in viajes" :key="viaje.id" class="mb-6 p-4 border rounded-lg shadow-md bg-gray-50">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xl font-semibold text-gray-700">Motivo: {{ viaje.motivo_viaje }}</h4>
                                    <span 
                                        :class="{
                                            'bg-green-500': viaje.estado === 'terminado',
                                            'bg-yellow-500': viaje.estado !== 'terminado',
                                        }" 
                                        class="text-white py-1 px-3 rounded-md">
                                        {{ viaje.estado === 'terminado' ? 'Terminado' : 'En Proceso' }}
                                    </span>

                                    <!-- Solo muestra el checkbox si el viaje no está terminado -->
                                    <template v-if="viaje.estado !== 'terminado'">
                                        <input 
                                            type="checkbox" 
                                            v-model="viaje.estado" 
                                            @change="toggleEstado(viaje)" 
                                            :checked="viaje.estado === 'terminado'" 
                                            class="form-checkbox h-5 w-5 text-blue-600"
                                        />
                                    </template>
                                </div>

                                <div class="space-y-2 text-gray-600">
                                    <p><strong>Origen:</strong> {{ viaje.origen_viaje }}</p>
                                    <p><strong>Destino:</strong> {{ viaje.destinatario }}</p>
                                    <p><strong>Fecha de Inicio:</strong> {{ viaje.fecha_hora_inicio }}</p>
                                </div>

                                <!-- Mostrar información del bus asignado -->
                                <div v-if="viaje.bus" class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <p><strong>Bus Asignado:</strong> {{ viaje.bus.Marca }} {{ viaje.bus.Modelo }}</p>
                                    <p><strong>Placa:</strong> {{ viaje.bus.placa }}</p>
                                    <p><strong>Capacidad:</strong> {{ viaje.bus.Capacidad }} pasajeros</p>
                                </div>

                                <div v-else class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <p>No se ha asignado un bus para este viaje.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Mostrar mensaje si no hay viajes -->
                        <div v-else>
                            <p>No tienes viajes asignados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutConductor>
</template>
