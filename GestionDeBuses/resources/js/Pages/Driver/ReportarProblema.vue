<script setup>
import { reactive, toRefs } from 'vue';
import AuthenticatedLayoutConductor from '@/Layouts/AuthenticatedLayoutConductor.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

// Define props
const props = defineProps({
    viaje: Object, // Recibe el viaje desde Laravel
    reportado: Boolean, // Indica si ya se ha reportado un problema
});

// Reactive form data
const form = reactive({
    descripcion: '',
    estado: '',
    lugar: '',
    observaciones: '',
    viaje_id: props.viaje ? props.viaje.id : '', // Asegúrate de que el viaje_id esté presente
});

// Submit form function
function submitForm() {
    // Asegúrate de que el viaje_id esté presente
    if (!form.viaje_id) {
        console.error("viaje_id no está presente");
        return;
    }

    Inertia.post(route('driver.reportarProblema.store'), form)
        .then(() => {
            // Redirigir a la página de rutas si es exitoso
            Inertia.visit(route('driver.conductorRutas'));
        })
        .catch(err => {
            // Manejo de errores
            console.error('Error al reportar el problema:', err);
        });
}

</script>

<template>
    <Head title="Reportar Problema" />

    <AuthenticatedLayoutConductor>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Reportar un Problema Técnico
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="props.viaje">
                            <h3 class="text-lg font-bold mb-4">Reportar un problema para el viaje: {{ props.viaje.motivo_viaje }}</h3>
                            
                            <div v-if="props.reportado">
                                <p>Ya has reportado un problema para este viaje.</p>
                            </div>
                            <div v-else>
                                <form @submit.prevent="submitForm" class="space-y-4">
                                    <!-- Descripción del problema -->
                                    <div>
                                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción del problema</label>
                                        <input
                                            v-model="form.descripcion"
                                            type="text"
                                            id="descripcion"
                                            required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>

                                    <!-- Estado -->
                                    <div>
                                        <label for="estado" class="block text-sm font-medium text-gray-700">Estado del problema</label>
                                        <select
                                            v-model="form.estado"
                                            id="estado"
                                            required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                            <option value="leve">Leve</option>
                                            <option value="fatal">Fatal</option>
                                            <option value="grave">Grave</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>

                                    <!-- Lugar -->
                                    <div>
                                        <label for="lugar" class="block text-sm font-medium text-gray-700">Lugar del problema</label>
                                        <input
                                            v-model="form.lugar"
                                            type="text"
                                            id="lugar"
                                            required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        />
                                    </div>

                                    <!-- Observaciones -->
                                    <div>
                                        <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones adicionales</label>
                                        <textarea
                                            v-model="form.observaciones"
                                            id="observaciones"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        ></textarea>
                                    </div>

                                    <!-- Botón para enviar el reporte -->
                                    <div>
                                        <button
                                            type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            Reportar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div v-else>
                            <p>No tienes un viaje asignado para reportar un problema.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutConductor>
</template>

<style scoped>
/* Puedes agregar estilos personalizados si es necesario */
</style>
