import { createApp } from "vue"; //
// import HelloVue from "./components/HelloVue.vue";
import router from "./index.js";
import Index from "./index.vue";

createApp(Index).use(router).mount("#register");
