import "./bootstrap";
import { createApp } from "vue";
import { store } from "./store";
import { toast } from "vue3-toastify";
import {
    currency,
    link,
    lang,
} from "./functions";
import AddToCart from "./components/AddToCart.vue";
import Cart from "./components/Cart.vue";
import Checkout from "./components/Checkout.vue";

const app = createApp({});

const notify = toast;
window.notify = notify;

app.config.globalProperties.$currency = currency;
app.config.globalProperties.$link = link;
app.config.globalProperties.$lang = lang;

app.component("addtocart", AddToCart);
app.component("cart", Cart);
app.component("checkout", Checkout);
app.use(store);

app.mount("#app");
