<template>
    <v-card>
        <v-container class="position-relative">
            <v-img
                class="opacity-5"
                :aspect-ratio="1"
                cover
                :src="pictureUrl"
            ></v-img>
            <div class="position-absolute">
                <v-card-text>
                    <span class="text-overline">{{ truck.model }}</span> <br />
                    <span class="text-caption">{{
                        truck.brand
                    }}</span></v-card-text
                >
                <!-- <v-card-text>  </v-card-text> -->
            </div>
        </v-container>
    </v-card>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    props: {
        truck: {
            type: Object,
            required: true,
        },
        pictureUrl: {
            type: String,
        },
    },
    data() {
        return {};
    },
});
</script>
<style scoped>
.position-absolute {
    position: absolute;
    top: 0;
    left: 0;
}
.position-relative {
    position: relative;
}
.opacity-5 {
    opacity: 0.3;
}
</style>
