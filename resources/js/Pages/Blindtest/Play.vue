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

onMounted(() => {
    axios.get(route('api.blindtest.get-next-track', [props.session.id]))
        .then(function (response) {
            // handle success
            nextSessionTrack.value = response.data;
            console.log(nextSessionTrack.value);

            canDisplayWaitingScene.value = false;
            canDisplayStartScene.value = true;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .finally(function () {
            // always executed
        });
    console.log(`the component is now mounted.`);
})

function start() {

    canDisplayStartScene.value = false;
    canDisplayGuessScene.value = true;

    var sound = new Howl({
        src: [nextSessionTrack.value.track.mp3_url],
        format: ['mp3'],
    });

    sound.once('load', function () {
        timer.value = 30;

        setInterval(() => {
            if (sound.playing()) {
                timer.value -= 1;
            }
        }, 1000);
    });

    sound.on('end', function () {
        axios.get(route('api.blindtest.track-failed', [props.session.id, nextSessionTrack.value.track.id]))
            .then(function (response) {
                // handle success
                canDisplayGuessScene.value = false;
                canDisplayEndScene.value = true;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
                // always executed
            });
    });

    // console.log(sound.duration())
    sound.play();
}



const submitTrackName = () => {
    if (nextSessionTrack.value.track.name == form.trackName) {
        axios.get(route('api.blindtest.track-succeed', [props.session.id, nextSessionTrack.value.track.id]))
            .then(function (response) {
                // handle success
                canDisplayGuessScene.value = false;
                hasSucceed.value = true;
                canDisplayEndScene.value = true;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
                // always executed
            });
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>BLINDTEST</h1>

                <div v-if="canDisplayWaitingScene">
                    <h2>Loading...</h2>
                </div>


                <div v-if="canDisplayStartScene">
                    <h2>Son x / x</h2>
                    <button @click="start">Commencer</button>
                </div>

                <div v-if="canDisplayGuessScene">
                    <form @submit.prevent="submitTrackName">
                        <div>
                            <input v-model="form.trackName" />
                        </div>

                        <button class="btn btn-primary">Send</button>

                    </form>

                    {{ timer }}
                </div>

                <div v-if="canDisplayEndScene">

                    <h3 v-if="hasSucceed">Well Done !</h3>
                    <h3 v-else>Too bad...</h3>

                    <p>This track was : {{ nextSessionTrack.track.name }}</p>

                    <a class="btn btn-success" :href="route('blindtest.play', [props.session.id])">NEXT</a>
                </div>

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


