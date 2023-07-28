<script setup>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';


const form = useForm({
});

const submit = () => {
    form.post(route('session.store'));
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
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

        <h1>c le dashboard</h1>

        <form @submit.prevent="submit">
            <button class="btn btn-success">Nouveau blindtest</button>
        </form>

    </AuthenticatedUserLayout>
</template>
