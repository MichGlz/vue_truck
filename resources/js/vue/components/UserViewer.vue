<template>
    <div class="truck__viewer">
        <v-sheet class="mx-auto mb-4 bg-transparent" max-width="800">
            <h4
                v-if="title"
                class="d-flex justify-space-between text-2xl font-bold text-white p-2 bg-blur"
            >
                <span
                    ><span class="d-inline-block">{{ title }}</span
                    ><span
                        v-if="user"
                        class="d-inline-block ml-2 text-3xl capitalize"
                    >
                        {{ user?.name }}</span
                    ></span
                >
                <span class="d-inline-block ml-10">
                    your balance: ${{ user?.vbalance }}</span
                >
            </h4>
            <v-carousel
                v-model="model"
                hide-delimiters
                :show-arrows="false"
                height="fit-content"
            >
                <template v-if="trucks.length > 0">
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
                                :isStore="false"
                            ></big-card>
                        </v-sheet>
                    </v-carousel-item>
                </template>
                <!-- Render a single carousel item if there are no trucks -->
                <template v-else>
                    <v-carousel-item>
                        <v-sheet
                            class="py-3 d-flex flex-column justify-center align-center bg-blur"
                            height="100%"
                            tile
                        >
                            <h2>You don't have any trucks</h2>
                            <v-btn color="primary mt-4" href="/#store"
                                >Go to Store</v-btn
                            >
                        </v-sheet>
                    </v-carousel-item>
                </template>
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
                    <small-card
                        class="img-btn ma-1 bg-grey-darken-3 color-white"
                        :class="i === model ? 'border-orange' : ''"
                        :pictureUrl="pictureUrl(i, 'medium')"
                        :truck="truck"
                        @click="selectTruck(i, toggle)"
                    />
                </v-slide-group-item>
            </v-slide-group>
        </v-sheet>
    </div>
</template>

<script>
import BigCard from "./BigCard.vue";
import SmallCard from "./SmallCard.vue";

export default {
    props: {
        title: {
            type: String,
        },
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            picturesUrl: [],
            model: 0,
            vehicle: {},
        };
    },
    components: {
        BigCard,
        SmallCard,
    },
    methods: {
        selectTruck(i, toggle) {
            //update ui
            toggle();
            this.model = i;
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
        },
    },
    computed: {
        trucks() {
            return this.user?.vehicles || [];
        },
    },
    mounted() {
        this.fetchTestImages();
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
