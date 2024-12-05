<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Recibimos las props del backend a través de Inertia
const props = defineProps({
    viajes: Array,
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
                        <div v-if="props.viajes.length > 0">
                            <!-- Mostrar la lista de viajes -->
                            <div v-for="viaje in props.viajes" :key="viaje.id" class="p-4 border-b">
                                <!-- Información del viaje -->
                                <p><strong>Placa del Bus:</strong> {{ viaje.bus?.placa }}</p>
                                <p><strong>Marca:</strong> {{ viaje.bus?.marca }}</p>
                                <p><strong>Modelo:</strong> {{ viaje.bus?.modelo }}</p>

                                <p><strong>Conductor:</strong> {{ viaje.user?.name }}</p>
                                <p><strong>Correo del Conductor:</strong> {{ viaje.user?.email }}</p>

                                <p><strong>Origen:</strong> {{ viaje.origen_viaje }}</p>
                                <p><strong>Motivo:</strong> {{ viaje.motivo_viaje }}</p>
                                <p><strong>Destinatario:</strong> {{ viaje.destinatario }}</p>

                                <p><strong>Fecha de Partida:</strong> {{ viaje.fecha_hora_inicio }}</p>
                                <p><strong>Fecha de Llegada:</strong> {{ viaje.fecha_hora_llegada }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <p>No hay viajes registrados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
