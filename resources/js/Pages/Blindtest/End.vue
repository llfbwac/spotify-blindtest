<script setup>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Howl, Howler } from 'howler';
import { onMounted, ref } from 'vue'

const props = defineProps(['session']);
const nextSessionTrack = ref(null);
const form = useForm({});

const canDisplayWaitingScene = ref(true);
const canDisplayStartScene = ref(false);
const canDisplayGuessScene = ref(false);
const canDisplayEndScene = ref(false);
const hasSucceed = ref(false);


const test = ref('zaeoio');

const timer = ref(null);



</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>END</h1>

                <p>Score : {{ props.session.score }}</p>

                <a class="btn btn-success" :href="route('dashboard')">DASHBOARD</a>
            </div>
        </div>
    </AuthenticatedUserLayout>
</template>


