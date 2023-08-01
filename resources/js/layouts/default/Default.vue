<template>
  <v-app>
    <div class="content">
      <default-bar />
      <side-bar
        :visible="store.drawer"
        :items-side-bar="itemsSideBar"
        :to="itemsSideBar.to"
        link
      ></side-bar>
      <default-view />
    </div>
  </v-app>
</template>

<script setup>
import DefaultBar from "./AppBar.vue";
import SideBar from "./SideBar.vue";
import DefaultView from "./View.vue";
import { useLoginStore } from "../../store/Login/login";
import { ref } from "vue";

const store = useLoginStore();

const itemsSideBar = ref([
  {
    title: "Posts",
    value: "posts",
    icon: "mdi-post",
    to: "/posts",
  },
  {
    title: "User",
    value: "user",
    icon: "mdi-account-outline",
    to: "/user",
  },
]);
</script>

<style lang="scss">
.content {
  height: 100vh;
  width: 100vw;
  display: flex;
  justify-content: center;
  // align-items: center;
}
</style>
