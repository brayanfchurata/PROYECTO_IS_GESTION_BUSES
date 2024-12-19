<script setup>
import { ref } from 'vue';
import AuthenticatedLayoutMantenimiento from '@/Layouts/AuthenticatedLayoutMantenimiento.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

// Props recibidas desde Inertia
defineProps({
    reportes: Array, // Datos de los reportes de mantenimiento
});

// Método para actualizar el estado de un reporte
const updateEstado = async (reporteId, estado) => {
    try {
        // Realizamos la solicitud para cambiar el estado del reporte
        await Inertia.patch(route('maintenance.updateEstado', reporteId), { estado });

        // Actualizamos el estado del reporte en el array de 'reportes' después de la actualización
        const reporte = reportes.find(r => r.id === reporteId);
        if (reporte) {
            reporte.estado = estado;
        }
    } catch (error) {
        console.error('Error al actualizar el estado del reporte:', error);
    }
};

// Método para cambiar el estado en el frontend (localmente)
const toggleEstado = (reporte) => {
    const nuevoEstado = reporte.estado === 'terminado' ? 'en_proceso' : 'terminado';
    updateEstado(reporte.id, nuevoEstado);
};

// Método para reportar problemas técnicos del bus
const reportarProblema = (reporte) => {
    Inertia.get(route('driver.reportarProblema', { viajeId: reporte.viaje.id }));
};

// Método para generar boleta
const generarBoleta = (reporte) => {
    alert(`Generando boleta para el reporte con ID: ${reporte.id}`);
};
</script>

<template>
    <Head title="Reportes de Mantenimiento" />

    <AuthenticatedLayoutMantenimiento>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                Lista de Reportes de Mantenimiento
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Mostrar reportes de mantenimiento -->
                        <div v-if="reportes.length">
                            <h3 class="font-bold text-lg mb-4">Lista de Reportes</h3>
                            <div v-for="reporte in reportes" :key="reporte.id" class="mb-6 p-4 border rounded-lg shadow-md bg-gray-50">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xl font-semibold text-gray-700">Descripción: {{ reporte.descripcion }}</h4>
                                    <span 
                                        :class="{
                                            'bg-green-500': reporte.estado === 'terminado',
                                            'bg-yellow-500': reporte.estado === 'en_proceso',
                                            'bg-red-500': reporte.estado === 'pendiente',
                                        }" 
                                        class="text-white py-1 px-3 rounded-md">
                                        {{ reporte.estado }}
                                    </span>

                                    <!-- Checkbox para marcar como terminado -->
                                    <template v-if="reporte.estado !== 'terminado'">
                                        <input 
                                            type="checkbox" 
                                            v-model="reporte.estado" 
                                            @change="toggleEstado(reporte)" 
                                            :checked="reporte.estado === 'terminado'" 
                                            class="form-checkbox h-5 w-5 text-blue-600"
                                        />
                                    </template>
                                </div>

                                <div class="space-y-2 text-gray-600">
                                    <p><strong>Lugar de averió:</strong> {{ reporte.lugar }}</p>
                                    <p><strong>Observaciones:</strong> {{ reporte.observaciones }}</p>
                                    <p><strong>Motivo del Viaje:</strong> {{ reporte.viaje.motivo_viaje }}</p>
                                    <p><strong>Destino:</strong> {{ reporte.viaje.destinatario }}</p>
                                    <p><strong>Conductor Encargado:</strong> {{ reporte.viaje.conductor.name }}</p>
                                    <p><strong>Email del Conductor:</strong> {{ reporte.viaje.conductor.email }}</p>
                                </div>

                                <!-- Mostrar información del bus asignado -->
                                <div v-if="reporte.viaje.bus" class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <p><strong>Bus Asignado:</strong> {{ reporte.viaje.bus.Marca }} {{ reporte.viaje.bus.Modelo }}</p>
                                    <p><strong>Placa:</strong> {{ reporte.viaje.bus.placa }}</p>
                                </div>

                                <div v-else class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <p>No se ha asignado un bus para este viaje.</p>
                                </div>

                                <!-- Botón para generar boleta -->
                                <button 
                                    v-if="reporte.estado === 'terminado'" 
                                    @click="generarBoleta(reporte)" 
                                    class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Generar Boleta
                                </button>
                            </div>
                        </div>

                        <!-- Mostrar mensaje si no hay reportes -->
                        <div v-else>
                            <p>No hay reportes de mantenimiento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutMantenimiento>
</template>

<style scoped>
/* Puedes agregar estilos personalizados si es necesario */
</style>
