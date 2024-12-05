<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Props recibidas del backend
defineProps({
    buses: Array,
    conductores: Array,
});

// Valores iniciales del formulario
const initialValues = {
    bus_id: '',
    user_id: '',
    motivo_viaje: '',
    origen_viaje: '',
    destinatario: '',
    fecha_hora_inicio: '',
    fecha_hora_llegada: '',
};

// Estado del formulario con Inertia
const form = useForm(initialValues);

// Manejador del envío del formulario
const handleSubmit = () => {
    form.post(route('admin.viajes.store'), {
        onSuccess: () => {
            // Redirige a la lista de viajes después de guardar
            window.location.href = route('admin.viajes');
        },
        onError: () => {
            console.error('Hubo un error al guardar el viaje');
        }
    });
};
</script>

<template>
    <Head title="Formulario de Asignación de Viaje" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Asignar Viaje
                </h2>
                <Link
                    :href="route('admin.viajes')"
                    class="text-blue-600 hover:underline"
                >
                    Ver lista de viajes
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-100">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-gray-700 mb-4">
                            Asignar un bus y conductor a un viaje
                        </h2>

                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <!-- Selección de Bus -->
                            <div>
                                <label
                                    for="bus_id"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Selecciona un Bus
                                </label>
                                <select
                                    id="bus_id"
                                    v-model="form.bus_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                >
                                    <option disabled value="">Selecciona un bus</option>
                                    <option
                                        v-for="bus in buses"
                                        :key="bus.id"
                                        :value="bus.id"
                                    >
                                        {{ bus.placa }} - {{ bus.Marca }} - {{ bus.Modelo }} ({{ bus.Capacidad }} pasajeros)
                                    </option>
                                </select>
                            </div>

                            <!-- Selección de Conductor -->
                            <div>
                                <label
                                    for="user_id"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Selecciona un Conductor
                                </label>
                                <select
                                    id="user_id"
                                    v-model="form.user_id"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                >
                                    <option disabled value="">Selecciona un conductor</option>
                                    <option
                                        v-for="conductor in conductores"
                                        :key="conductor.id"
                                        :value="conductor.id"
                                    >
                                        {{ conductor.name }} ({{ conductor.email }})
                                    </option>
                                </select>
                            </div>

                            <!-- Campos de texto -->
                            <div>
                                <label
                                    for="motivo_viaje"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Motivo del Viaje
                                </label>
                                <input
                                    id="motivo_viaje"
                                    type="text"
                                    v-model="form.motivo_viaje"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Ingresa el motivo del viaje"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    for="origen_viaje"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Origen del Viaje
                                </label>
                                <input
                                    id="origen_viaje"
                                    type="text"
                                    v-model="form.origen_viaje"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Ingresa el origen"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    for="destinatario"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Destinatario
                                </label>
                                <input
                                    id="destinatario"
                                    type="text"
                                    v-model="form.destinatario"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Nombre del destinatario"
                                    required
                                />
                            </div>

                            <!-- Fecha y Hora -->
                            <div>
                                <label
                                    for="fecha_hora_inicio"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Fecha y Hora de Inicio
                                </label>
                                <input
                                    id="fecha_hora_inicio"
                                    type="datetime-local"
                                    v-model="form.fecha_hora_inicio"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    for="fecha_hora_llegada"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Fecha y Hora de Llegada (opcional)
                                </label>
                                <input
                                    id="fecha_hora_llegada"
                                    type="datetime-local"
                                    v-model="form.fecha_hora_llegada"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                            </div>

                            <!-- Botón de Envío -->
                            <div class="text-right">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Asignar Viaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
