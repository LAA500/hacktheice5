<template>
    <form method="POST" @submit.prevent="purchase()">
        <div class="form-group mb-3">
            <div class="form-floating">
                <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    class="form-control"
                    placeholder="Ваше имя"
                    autocomplete="given-name"
                />
                <label for="name">Ваше имя</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="form-floating">
                <input
                    type="text"
                    id="phone"
                    v-model="form.phone"
                    class="form-control"
                    placeholder="Номер телефона"
                    autocomplete="tel"
                />
                <label for="phone">Номер телефона</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="form-floating">
                <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    class="form-control"
                    placeholder="Email"
                    autocomplete="email"
                />
                <label for="email">Email</label>
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="form-floating">
                <textarea
                    v-model="form.address"
                    id="address"
                    class="form-control"
                    placeholder="Адрес доставки"
                    cols="30"
                    rows="3"
                    style="height: 90px"
                ></textarea>
                <label for="address">Адрес доставки</label>
            </div>
        </div>
        <div class="form-group">
            <button
                type="submit"
                class="btn btn-lg btn-primary fw-bold text-white"
                :class="{ 'btn-loading': loader }"
                :disabled="loader"
            >
                <span>Подтвердить заказ</span>
            </button>
        </div>
    </form>
</template>

<script>
import Errors from "../errors.js";
export default {
    name: "Checkout",

    data() {
        return {
            loader: false,
            form: {
                name: null,
                phone: null,
                email: null,
                address: null,
            },
            errors: new Errors(),
        };
    },

    methods: {
        purchase() {
            this.loader = true;
            axios
                .post(route("ajax.purchase"), this.form)
                .then((response) => {
                    if (response.data.success) {
                        window.location.href = route(
                            "complete",
                            response.data.order.uuid
                        );
                    } else {
                        this.errors.record(response.data.errors);
                        notify.error(response.data.message);
                    }
                })
                .catch((error) => {
                    notify.error(error.response.data.message);
                })
                .finally(() => {
                    setTimeout(() => {
                        this.loader = false;
                    }, 3000);
                });
        },
    },
};
</script>
