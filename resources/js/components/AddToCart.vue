<template>
    <button
        type="button"
        :class="{ 'btn-loading': loader }"
        :disabled="loader"
        @click="addToCart()"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "AddToCart",

    props: {
        uuid: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            loader: false,
        };
    },

    methods: {
        async addToCart() {
            this.loader = true;
            axios
                .post(route("ajax.cart.act", "add"), {
                    uuid: this.uuid,
                    qty: 1,
                })
                .then((response) => {
                    if (response.data.success) {
                        /* if (window.location.pathname != "/cart") {
                            this.$modalShow("#addedToCart");
                        } */
                        window.location.href = route('cart');
                        this.$store.dispatch("SAVE_CART", response.data);
                    } else {
                        notify(response.data.message, "error");
                    }
                })
                .catch((error) => {
                    notify(
                        error.response?.data.message || error.message,
                        "error"
                    );
                })
                .finally(() => {
                    setTimeout(() => {
                        this.loader = false;
                    }, 2000);
                });
        },
    },
};
</script>
