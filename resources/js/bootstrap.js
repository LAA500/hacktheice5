import jquery from "jquery";
window.$ = jquery;
window.jQuery = jquery;

import "bootstrap";

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
