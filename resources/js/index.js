import { createRouter, createWebHistory } from "vue-router";
import Register from "./Register.vue";
import LoginForm from "./LoginForm.vue";

const routes = [
    {
        path: "/",
        component: Register,
    },
    {
        path: "/login",
        component: LoginForm,
    },
    // {
    //     path: "/dashboard",
    //     component: DashboardView,
    // },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
