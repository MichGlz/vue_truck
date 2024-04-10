<template>
    <v-container class="bg-map">
        <div v-if="!user" class="d-flex justify-center align-center h-screen">
            <v-progress-circular
                :size="70"
                :width="7"
                color="purple"
                indeterminate
            ></v-progress-circular>
        </div>
        <div v-else>
            <user-viewer class="mb-4" title="Your Trucks" :user="user" />
            <hr id="store" />
            <truck-viewer
                class="my-4"
                title="Store"
                :user="user"
                @vehicleAdded="fetchUser"
            />
        </div>
    </v-container>
</template>
<script>
import TruckViewer from "../Vue/components/TruckViewer.vue";
import UserViewer from "../Vue/components/UserViewer.vue";

export default {
    data() {
        return {
            userId: 2,
            X_CSRF_TOKEN: "",
            user: null,
        };
    },
    components: {
        TruckViewer,
        UserViewer,
    },
    methods: {
        fetchUser() {
            const options = { method: "GET" };
            const url = `/api/user/${this.userId}`;
            fetch(url, options)
                .then((response) => response.json())
                .then((response) => {
                    console.log(response);
                    this.user = { ...response.data };
                })
                .catch((err) => console.error(err));
        },
    },
    mounted() {
        this.X_CSRF_TOKEN = document.head.querySelector(
            'meta[name="csrf-token"]'
        ).content;
        this.fetchUser();
    },
};
</script>
