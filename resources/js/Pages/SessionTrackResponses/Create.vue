<script setup>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Howl, Howler } from 'howler';

// defineProps([
//     sessionTrack,
//     sessionTrackResponse
// ]);

const props = defineProps(['sessionTrack']);



const form = useForm({
    guess: ''
});

const submit = () => {
    form.post(route('session-track-response.store'));
};

var sound = new Howl({
    src: ['https://p.scdn.co/mp3-preview/176f264ae98696b6ac603018e53b80d5453d83ec?cid=3d8a56d2ab2040bc9719963a3d26f4fa'],
    format: ['mp3'],
});

// console.log("plaaayyyy");
// console.log(props.sessionTracks);
sound.play();
function howly(event) {
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>blindtest</h1>

                {{ sessionTrack.name }}

                <form @submit.prevent="submit">
                    <div>

                        <input v-model="form.guess" />

                    </div>

                    <button class="btn btn-primary">Valider réponse</button>

                </form>

                <!-- <button @click="howly">Toggle Playcc</button>
                <form @submit.prevent="submit">

                    <button class="btn btn-primary">Valider réponse</button>

                </form> -->
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


