<script setup>
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
        console.log(response.media);
        const images = response.media;
        images.forEach((image) => {
            console.log(image.src.tiny);
            const img = document.createElement("img");
            img.src = image.src.tiny;
            document.querySelector("body").prepend(img);
        });
    })
    .catch((err) => console.error(err));
</script>
<template>
    <h1>My App</h1>
</template>
