<template>
  <v-app>
    <div class="content mt-8">
      <default-bar />
      <side-bar :visible="store.drawer" :items-side-bar="itemsSideBar"></side-bar>
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
    title: "Foo",
    value: "foo",
  },
  {
    title: "Bar",
    value: "bar",
  },
  {
    title: "Fizz",
    value: "fizz",
  },
  {
    title: "Buzz",
    value: "buzz",
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
