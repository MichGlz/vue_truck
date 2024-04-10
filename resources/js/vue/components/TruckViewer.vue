<template>
    <div class="truck__viewer">
        <v-sheet class="mx-auto mb-4 bg-transparent" max-width="800">
            <h4 v-if="title" class="d-flex justify-space-between">
                <span class="d-inline-block">{{ title }}</span
                ><span class="d-inline-block">
                    your balance: ${{ user?.vbalance }}</span
                >
            </h4>
            <v-carousel
                v-model="model"
                hide-delimiters
                :show-arrows="false"
                height="fit-content"
            >
                <v-carousel-item
                    v-for="(truck, i) in trucks"
                    :key="'pic-' + i"
                    :value="i"
                >
                    <v-sheet class="py-3 bg-blur" height="100%" tile>
                        <big-card
                            :truck="truck"
                            :pictureUrl="pictureUrl(i, 'large')"
                            @add="handleAddVehicle"
                            :userBalance="user?.vbalance"
                        ></big-card>
                    </v-sheet>
                </v-carousel-item>
            </v-carousel>
        </v-sheet>
        <v-sheet class="mx-auto" max-width="800">
            <v-slide-group show-arrows>
                <v-slide-group-item
                    v-for="(truck, i) in trucks"
                    :key="'mini-' + i"
                    :value="i"
                    v-slot="{ toggle }"
                >
                    <img
                        class="img-btn ma-3"
                        :class="i === model ? 'border-orange' : ''"
                        :src="pictureUrl(i, 'medium')"
                        alt=""
                        @click="selectTruck(i, toggle)"
                    />
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>
    </div>
</template>

<script>
import BigCard from "../../Vue/components/BigCard.vue";
export default {
    props: {
        title: {
            type: String,
        },
        user: {
            type: Object,
        },
    },
    data() {
        return {
            picturesUrl: [],
            trucks: [],
            model: 0,
            vehicle: {},
        };
    },
    components: {
        BigCard,
    },
    methods: {
        selectTruck(i, toggle) {
            //update ui
            toggle();
            this.model = i;
        },

        fetchTrucks() {
            const urlBase = "/api/vehicles";

            const options = {
                method: "GET",
            };

            fetch(urlBase, options)
                .then((response) => response.json())
                .then((response) => {
                    // console.log(response.data);
                    const vehicles = response.data;
                    this.trucks = [...vehicles];
                })
                .catch((err) => console.error(err));
        },

        fetchTestImages() {
            const urlBase =
                "https://api.pexels.com/v1/collections/ydhkom9?per_page=10&sort=desc";

            const options = {
                method: "GET",
                headers: {
                    Accept: "'application/json'",
                    Authorization:
                        "ASFXG41x5Pl1N6G5DoGrLV60sEM66CO8xBQfNTkUBSZlKNQEVOTCvVWJ",
                },
            };

            fetch(urlBase, options)
                .then((response) => response.json())
                .then((response) => {
                    //console.log(response.media);
                    const images = response.media;
                    const urls = images.map((img) => img.src);
                    this.picturesUrl = [...urls];
                })
                .catch((err) => console.error(err));
        },

        pictureUrl(truckIndex, size) {
            const totalImages = this.picturesUrl.length;
            if (totalImages < 1) return;
            const imageIndex = truckIndex % totalImages;
            // Check if the truck index is higher than the length of the image URLs array
            if (truckIndex >= totalImages) {
                return this.picturesUrl[imageIndex][size];
            } else {
                return this.picturesUrl[truckIndex][size];
            }
        },

        handleAddVehicle(data) {
            console.log(data);
            const X_CSRF_TOKEN = document.head.querySelector(
                'meta[name="csrf-token"]'
            ).content;
            const url = `/api/user/${this.user?.id}/add-vehicle`;
            const options = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": X_CSRF_TOKEN,
                },
                body: `{
                "vehicle_id":"${data.truck.id}",
                "color":"${data.color}",
                "cubic_m":"${data.size}"
                }`,
            };

            fetch(url, options)
                .then((response) => response.json())
                .then((response) => {
                    console.log(response);
                    this.$emit("vehicleAdded");
                })
                .catch((err) => console.error(err));
        },
    },
    computed: {},
    mounted() {
        this.fetchTestImages();
        this.fetchTrucks();
    },
};
</script>
<style scoped>
.img-btn {
    width: 120px;
    object-fit: cover;
    aspect-ratio: 1/1;
    cursor: pointer;
}
.border-orange {
    box-shadow: 0 0 10px 2px #733607;
}
</style>
