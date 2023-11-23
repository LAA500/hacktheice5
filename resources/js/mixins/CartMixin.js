import Errors from "../errors";
export default {
    data() {
        return {
            loader: false,
            errors: new Errors(),
        };
    },

    computed: {
        cart() {
            return this.$store.getters.CART;
        },
    },

    methods: {
        removeitem(index) {
            axios
                .post(route("ajax.cart.act", "remove"), { index: index })
                .then((response) => {
                    this.$store.dispatch("SAVE_CART", response.data);
                })
                .catch((error) => {
                    notify.error(error.response.data.message, "error");
                    setTimeout(() => {
                        window.location.reload();
                    }, 4000);
                });
        },

        recalc(index, type) {
            axios
                .post(route("ajax.cart.act", "recalc"), {
                    index: index,
                    type: type,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.$store.dispatch("SAVE_CART", response.data);
                    } else {
                        notify.error(response.data.message, "error");
                    }
                })
                .catch((error) => {
                    notify.error(
                        error.response?.data.message || error.message,
                        "error"
                    );
                });
        },

        checkout() {
            try {
                this.loader = true;
                setTimeout(() => {
                    window.location.href = route("checkout");
                }, 1000);
            } catch (err) {
                window.location.assign(route("checkout"));
            } finally {
                setTimeout(() => {
                    this.loader = false;
                }, 2000);
            }
        },
    },
};
