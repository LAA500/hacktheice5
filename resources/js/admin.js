import "./bootstrap";
import { createApp } from "vue";
import { toast } from "vue3-toastify";
import {
    currency,
    link,
    lang,
} from "./functions";
import SupplyCreate from "./components/SupplyCreate.vue";

const app = createApp({});

const notify = toast;
window.notify = notify;

app.config.globalProperties.$currency = currency;
app.config.globalProperties.$link = link;
app.config.globalProperties.$lang = lang;

app.component("supplycreate", SupplyCreate);

app.mount("#app");
