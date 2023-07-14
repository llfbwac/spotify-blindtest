<script setup>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';


const form = useForm({
});

const submit = () => {
    form.post(route('session-track-response.store'));
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>blindtest</h1>

                <form @submit.prevent="submit">


                    <button class="btn btn-primary">Valider réponse</button>

                </form>
            </div>
        </div>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div> -->
    </AuthenticatedUserLayout>
</template>
