<script setup>
import AuthenticatedUserLayout from '@/Layouts/AuthenticatedUserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Howl, Howler } from 'howler';
import { onMounted, ref } from 'vue'

const props = defineProps(['session']);
const nextSessionTrack = ref(null);
const test = ref(null);
const canDisplayNextButton = ref(false);


onMounted(() => {
    axios.get(route('api.blindtest.get-next-track', [props.session.id]))
        .then(function (response) {
            // handle success
            nextSessionTrack.value = response.data;
            console.log(nextSessionTrack.value);

            var sound = new Howl({
                src: [nextSessionTrack.value.track.mp3_url],
                format: ['mp3'],
            });

            sound.play();
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




const form = useForm({
    // guess: ''
});

const submitTrackName = () => {
    // form.post(route('session-track-response.store'));

    console.log(nextSessionTrack.value.track.name);

    console.log();

    if (nextSessionTrack.value.track.name == form.trackName) {
        axios.get(route('api.blindtest.track-succeed', [props.session.id, nextSessionTrack.value.track.id]))
            .then(function (response) {
                // handle success
                test.value = 'OUI';
                canDisplayNextButton.value = true;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .finally(function () {
                // always executed
            });

    } else {
        test.value = 'NOPE';
        canDisplayNextButton.value = false;
    }


    // console.log(form.trackName);
};



function howly(event) {
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedUserLayout>
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1>PLAYY</h1>

                {{ session.id }}


                <form @submit.prevent="submitTrackName">
                    <div>

                        <input v-model="form.trackName" />

                    </div>

                    <!-- <button class="btn btn-primary">Valider réponse</button> -->

                </form>

                {{ test }}

                <a v-if="canDisplayNextButton" class="btn btn-success"
                    :href="route('blindtest.play', [props.session.id])">NEXT</a>


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


