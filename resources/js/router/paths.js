import Login from "../pages/Login/Login.vue";
import Post from "../pages/Post/Post.vue";
import Layout from "../layouts/default/Default.vue";
import User from "../pages/User/User.vue";

export default [
    {
        path: "/",
        name: "Login",
        component: Login,
        meta: {
            requiresAuth: false,
            guestOnly: true, // Add guestOnly meta field to indicate that only guests can access this route
        },
    },
    {
        path: "/home",
        name: "Home",
        meta: {
            requiresAuth: true,
        },
        // redirect: "/login",
        component: Layout,
        children: [
            { path: "/posts", name: "Posts", component: Post },
            { path: "/user", name: "User", component: User },
        ],
    },
];
