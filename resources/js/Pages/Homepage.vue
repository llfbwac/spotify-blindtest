<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

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
    <Head title="Welcome" />
    <GuestLayout>
        <div class="row justify-content-center mt-5">
            <div class="col-8 text-center">

                <h1>Spotify blindtest</h1>
                <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Dashboard</Link>

                    <template v-else>
                        <a class="btn btn-success" :href="route('login')">Login with Spotify</a>
                    </template>
                </div>
            </div>
        </div>

    </GuestLayout>
</template>

