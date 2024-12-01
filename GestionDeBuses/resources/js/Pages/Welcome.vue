<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Sistema de Gestión de Rutas de Buses" />
    <div class="welcome-container">
        <div class="relative flex min-h-screen flex-col items-center justify-center">
            <div class="relative w-full max-w-7xl px-6 lg:max-w-7xl">
                <!-- Encabezado fijo en la parte superior -->
                <header class="header-container">
                    <!-- Logo en la esquina superior izquierda -->
                    <img src="/images/unap-logo.png" alt="Logo UNAP" class="h-12 w-auto">

                    <!-- Enlaces de Login y Register en la esquina superior derecha -->
                    <nav class="flex space-x-4">
                        <a href="/login" class="btn-header">Login</a>
                        <a href="/register" class="btn-header">Register</a>
                    </nav>
                </header>

                <main class="main-content">
                    <!-- Contenido principal con un fondo semitransparente -->
                    <div class="text-center text-white z-10 bg-overlay rounded-lg p-8">
                        <h1 class="text-5xl font-extrabold mb-4 leading-tight">BIENVENIDO AL SISTEMA DE GESTION DE BUSES</h1>
                        <p class="text-xl mb-6">Una plataforma eficiente para la administración de rutas y horarios de buses, diseñada para la comunidad universitaria.</p>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>
.welcome-container {
    position: relative;
    background-image: url('/images/fondo.jpg'); /* Ruta de la imagen de fondo */
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    height: 100vh;
    margin: 0;
}

/* Overlay para oscurecer ligeramente la imagen de fondo */
.welcome-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5); /* Fondo oscuro con opacidad */
    z-index: 1;
}

/* Contenedor de encabezado */
.header-container {
    position: fixed; /* Fijamos el encabezado en la parte superior */
    top: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.6); /* Fondo oscuro con opacidad */
    z-index: 10;
    color: white;
    padding: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 80px;
}

.header-container nav {
    display: flex;
    gap: 16px;
}

.btn-header {
    color: rgb(2, 3, 40);
    text-decoration: none;
    padding: 0.75rem 1.25rem;
    background-color: rgba(255, 255, 255, 0.6); /* Fondo claro para los botones */
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-weight: 600;
}

.btn-header:hover {
    background-color: rgba(255, 255, 255, 0.8); /* Cambiar fondo en hover */
    transform: scale(1.05);
}

.main-content {
    margin-top: 120px; /* Espaciado superior para no tapar el encabezado */
    padding: 1rem;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
    height: calc(100vh - 120px); /* Asegura que el contenido quede centrado */
}

/* Estilo del texto central con fondo semitransparente más ancho */
.bg-overlay {
    background: rgba(0, 0, 0, 0.6); /* Fondo oscuro para mejorar contraste */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Sombra suave para dar profundidad */
    padding: 3rem; /* Aumento de padding para que el rectángulo sea más grande */
    max-width: 900px; /* Aumento del ancho del rectángulo */
    width: 100%;
}

/* Eliminar botones de login y register */
</style>
