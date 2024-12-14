<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Recibimos las props del backend a través de Inertia
const props = defineProps({
    viajes: Array,  // Se asume que "viajes" es una lista de objetos con la relación de "user" (conductor) y "bus"
    buses: Array,  // Datos de los buses
    conductor: Object, // Información del conductor
});
</script>

<template>
    <Head title="Viajes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Lista de Viajes
                </h2>
                <Link :href="route('admin.formularioViaje')" class="text-blue-600 hover:underline">
                    Asignar Nuevo Viaje
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Mostrar viajes -->
                        <div v-if="viajes.length">
                            <h3 class="font-bold text-lg mb-4">Lista de Viajes</h3>
                            <div v-for="viaje in viajes" :key="viaje.id" class="mb-6 p-4 border rounded-lg shadow-md bg-gray-50">
                                
                                <!-- Información del viaje -->
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
                                </div>

                                <!-- Detalles del viaje -->
                                <div class="space-y-2 text-gray-600">
                                    <p><strong>Origen:</strong> {{ viaje.origen_viaje }}</p>
                                    <p><strong>Destino:</strong> {{ viaje.destinatario }}</p>
                                    <p><strong>Fecha de Partida:</strong> {{ viaje.fecha_hora_inicio }}</p>
                                    <p><strong>Fecha de Llegada:</strong> {{ viaje.fecha_hora_llegada }}</p>
                                </div>

                                <!-- Información del conductor -->
                                <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <h5 class="font-semibold text-gray-700">Conductor:</h5>
                                    <p><strong>Nombre:</strong> {{ viaje.user ? viaje.user.name : 'No asignado' }}</p>
                                    <p><strong>Correo:</strong> {{ viaje.user ? viaje.user.email : 'No disponible' }}</p>
                                </div>

                                <!-- Información del bus asignado -->
                                <div v-if="viaje.bus" class="mt-4 p-4 bg-gray-100 rounded-lg">
                                    <h5 class="font-semibold text-gray-700">Bus Asignado:</h5>
                                    <p><strong>Marca:</strong> {{ viaje.bus.marca }}</p>
                                    <p><strong>Modelo:</strong> {{ viaje.bus.modelo }}</p>
                                    <p><strong>Placa:</strong> {{ viaje.bus.placa }}</p>
                                    <p><strong>Capacidad:</strong> {{ viaje.bus.capacidad }} pasajeros</p>
                                </div>

                                <!-- Si no hay bus asignado -->
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

    </AuthenticatedLayout>
</template>
