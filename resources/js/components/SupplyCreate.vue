<template>
    <form method="POST" @submit.prevent="create()">
        <div class="form-group mb-3">
            <div class="form-floating">
                <input
                    type="text"
                    v-model="form.number"
                    id="number"
                    class="form-control"
                    autocomplete="off"
                    placeholder="Номер поставки"
                />
                <label for="number">Номер поставки</label>
            </div>
            <div class="form-control-invalid" v-if="errors.has('name')">
                <span v-text="errors.get('number')"></span>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</template>

<script>
import Errors from "../errors.js";
export default {
    name: "SupplyCreate",

    data() {
        return {
            loader: false,
            form: {},
            errors: new Errors(),
        };
    },

    methods: {
        create() {
            this.loader = true;
            axios
                .post(route("admin.supplies.store"), this.form)
                .then((response) => {
                    if (response.data.success) {
                        window.location.href = route("admin.supplies.index");
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
