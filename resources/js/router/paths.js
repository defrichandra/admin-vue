import Index from "../pages/Index/index.vue"
import Register from "../pages/Register/Register.vue"
import Login from "../pages/Login/Login.vue";
import Post from "../pages/Post/Post.vue";
import Layout from "../layouts/default/Default.vue";
import User from "../pages/User/User.vue";
import Profile from "../pages/Profile/Profile.vue";

export default [
    {
        path: "/",
        name: "Index",
        component: Index,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            requiresAuth: false,
            guestOnly: true, // Add guestOnly meta field to indicate that only guests can access this route
        },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/home",
        name: "Home",
        meta: {
            requiresAuth: true,
        },
        component: Layout,
        children: [
            { path: "/posts", name: "Posts", component: Post },
            { path: "/user", name: "User", component: User },
            { path: "/profile", name: "Profile", component: Profile },
        ],
    },
];
