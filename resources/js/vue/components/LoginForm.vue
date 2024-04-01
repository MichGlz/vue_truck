<template>
    <form @submit.prevent="submitRegisterForm">
        <input type="hidden" name="_token" :value="csrfToken" />
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="formData.name" required />
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="formData.email" required />
        </div>
        <div>
            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                v-model="formData.password"
                required
            />
        </div>
        <div>
            <label for="confirmPassword">Confirm Password:</label>
            <input
                type="password"
                id="confirmPassword"
                v-model="formData.confirmPassword"
                required
            />
        </div>
        <button type="submit">Register</button>
    </form>
</template>

<script>
export default {
    props: {
        csrfToken: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            formData: {
                name: "",
                email: "",
                password: "",
                confirmPassword: "",
            },
        };
    },
    methods: {
        submitForm() {
            // Perform form submission logic here
            console.log("Form submitted with data:", this.formData);
        },
        submitRegisterForm() {
            const url = "/register";
            const options = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken, // Include CSRF token in the header
                },
                body: JSON.stringify(this.formData.value), // Convert form data to JSON string
            };

            fetch(url, options)
                .then((response) => {
                    console.log(response);
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Registration successful", data);
                    // Reset form fields if needed
                    this.formData.value = {
                        name: "",
                        email: "",
                        password: "",
                        confirmPassword: "",
                    };
                })
                .catch((error) => {
                    console.error(
                        "There was a problem with the registration:",
                        error
                    );
                    // Handle error, e.g., show error message to the user
                });
        },
    },
};
</script>
