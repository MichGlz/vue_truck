<template>
    <v-card :variant="variant" class="mx-auto pa-2" max-width="80%">
        <v-container class="d-flex">
            <v-container>
                <v-img
                    :aspect-ratio="1"
                    cover
                    :src="pictureUrl"
                    max-width="300px"
                ></v-img>
                <div>
                    <v-card-title> {{ truck.model }} </v-card-title>
                    <v-card-subtitle> {{ truck.brand }} </v-card-subtitle>
                </div>
            </v-container>
            <v-container>
                <v-card-text class="mb-0"> ${{ formattedPrice }} </v-card-text>
                <v-card-title>Options</v-card-title>
                <v-select
                    v-model="selectedColor"
                    :items="this.truck.colors"
                    label="Color"
                    :readonly="!isStore"
                ></v-select>
                <v-select
                    v-model="selectedSize"
                    :items="this.truck.sizes"
                    item-title="cubic_m"
                    item-value="cubic_m"
                    label="Cubic Meters"
                    :readonly="!isStore"
                ></v-select>
            </v-container>
        </v-container>
        <v-card-actions v-if="isStore">
            <v-btn class="ml-auto mb-3" @click="handleAddVehicle"> Add </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: {
        truck: {
            type: Object,
            required: true,
        },
        pictureUrl: {
            type: String,
        },
        isStore: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            selectedColor: this.isStore ? "white" : this.truck?.pivot?.color,
            selectedSize: this.isStore ? "10" : this.truck?.pivot?.cubic_m,
            formattedPrice: this.isStore
                ? this.truck.base_price
                : this.truck?.pivot?.price,
        };
    },
    methods: {
        updatePrice() {
            if (this.selectedSize) {
                const selectedSize = this.selectedSize;
                const sizeData = this.truck.sizes.find(
                    (size) => size.cubic_m === selectedSize
                );
                if (sizeData) {
                    const priceFactor = sizeData.price_factor || 1;
                    this.formattedPrice = (
                        this.truck.base_price * priceFactor
                    ).toFixed(2);
                }
            }
        },
        handleAddVehicle() {
            this.$emit("add", {
                truck: this.truck,
                color: this.selectedColor,
                size: this.selectedSize,
                price: this.formattedPrice,
            });
        },
    },
    watch: {
        selectedSize: "updatePrice",
    },
};
</script>
