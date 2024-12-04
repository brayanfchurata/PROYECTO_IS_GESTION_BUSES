<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { defineProps } from 'vue'


const props = defineProps({

    conductores: Array, // Recibimos la lista de conductores desde el controlador
})
</script>

<template>
    <Head title="Conductor" />

    <AuthenticatedLayout>
        <!-- Header de la página -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Conductores
            </h2>
        </template>

        <!-- Contenido principal de la página -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Teléfono
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí mostramos la lista de conductores -->
                                <tr v-for="conductor in conductores" :key="conductor.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ conductor.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ conductor.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ conductor.telefono }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <router-link
                                            :to="{ name: 'admin.conductor.show', params: { id: conductor.id } }"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Ver Detalles
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>