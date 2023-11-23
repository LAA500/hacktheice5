import { createStore } from "vuex";
import { notify } from "./functions";

export const store = createStore({
    state: {
        preloader: false,
        cart: App.cart,
        modalId: null,
    },
    getters: {
        CART: (state) => {
            return state.cart;
        },
        PRELOADER: (state) => {
            return state.preloader;
        },
        COMPARE: (state) => {
            return state.compare;
        },
        COMPARE_ATTRIBUTES: (state) => {
            return state.compare_attributes;
        },
        CUSTOMER: (state) => {
            return state.customer;
        },

        CART_QUANTITY: (state) => {
            return state.cart.quantity;
        },

        CART_TOTAL: (state) => {
            return state.cart?.total.formatted;
        },

        CART_EMPTY: (state) => {
            return state.cart?.empty;
        },

        COMPARE_QUANTITY: (state) => {
            return state.compare.length;
        },

        IN_COMPARE_LIST: (state) => (productId) => {
            return state.compare.find((item) => item.id == productId);
        },

        MODAL_ID: (state) => {
            return state.modalId;
        },
    },
    mutations: {
        SET_CART: (state, cart) => {
            state.cart = cart;
        },
        SET_PRELOADER: (state, preloader) => {
            state.preloader = preloader;
        },
        UPDATE_COMPARE: (state, compare) => {
            state.compare = compare;
        },
        UPDATE_COMPARE_ATTRIBUTES: (state, compare_attributes) => {
            state.compare_attributes = compare_attributes;
        },
        SAVE_DATA_COMPARE: (state) => {
            localStorage.setItem("_compare", JSON.stringify(state.compare));
        },
        SAVE_DATA_COMPARE_ATTRIBUTES: (state) => {
            localStorage.setItem(
                "_compare_attributes",
                JSON.stringify(state.compare_attributes)
            );
        },
        DELETE_FROM_COMPARE: (state, productId) => {
            const index = state.compare.findIndex(
                (product) => product.id === productId
            );
            if (index !== -1) {
                state.compare.splice(index, 1);
            }
        },
        SET_MODAL_ID: (state, modalId) => {
            state.modalId = modalId;
        },
    },
    actions: {
        SAVE_CART: async (context, payload) => {
            context.commit("SET_CART", payload);
        },

        UPDATE_PRELOADER: async (context, payload) => {
            context.commit("SET_PRELOADER", payload);
        },

        MODAL_ID: async (context, payload) => {
            context.commit("SET_MODAL_ID", payload);
        },

        CLEAR_COMPARE: async (context) => {
            context.commit("UPDATE_COMPARE", []);
            context.commit("UPDATE_COMPARE_ATTRIBUTES", []);
            context.commit("SAVE_DATA_COMPARE");
            context.commit("SAVE_DATA_COMPARE_ATTRIBUTES");
        },

        DELETE_COMPARE_PID: (context, productId) => {
            context.commit("DELETE_FROM_COMPARE", productId);
            context.commit("SAVE_DATA_COMPARE");
        },

        SYNC_COMPARE_LIST: async (context, productId) => {
            if (context.getters.IN_COMPARE_LIST(productId)) {
                context.commit("DELETE_FROM_COMPARE", productId);
                context.commit("SAVE_DATA_COMPARE");
                return;
            }
            const productIds = context.state.compare.map(
                (product) => product.id
            );
            axios
                .post(route("ajax.compare.store"), {
                    pid: productId,
                    pids: productIds,
                })
                .then((response) => {
                    if (response.data.success) {
                        context.state.compare.push(response.data.compare);
                        context.state.compare_attributes =
                            response.data.attributes;
                        context.commit("SAVE_DATA_COMPARE");
                        context.commit("SAVE_DATA_COMPARE_ATTRIBUTES");
                    } else {
                        notify(response.data.message, "error");
                    }
                })
                .catch((error) => {
                    notify(
                        error.response?.data.message || error.message,
                        "error"
                    );
                });
        },
    },
});
