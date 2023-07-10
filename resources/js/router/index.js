// Composables
import { createRouter, createWebHistory } from "vue-router";
import paths from "./paths";

const router = createRouter({
    // history: createWebHistory(process.env.BASE_URL),
    history: createWebHistory(),
    routes: paths,
});

//apply route guard
router.beforeEach((to, from, next) => {
    const isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn"));
    
    if (to.meta.requiresAuth && !isLoggedIn) {
        next({ name: "Login" }); // Redirect to the login route
    } else if (to.name === "Login" && isLoggedIn) {
        next({ name: "Posts" }); // Redirect to another route, e.g., the dashboard
    } else if (to.meta.guestOnly && isLoggedIn) {
        next({ name: "Posts" }); // Redirect to another route if trying to access guest-only route
    } else {
        next(); // Allow navigation to the requested route
    }
});

export default router;
