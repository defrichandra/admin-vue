<template>
  <v-app-bar flat color="#7b57ff">
    <v-app-bar-title>
      <v-icon
        :icon="store.drawer ? 'mdi-arrow-left' : 'mdi-menu'"
        @click.stop="store.drawer = !store.drawer"
      />
      <!-- Welcome -->
    </v-app-bar-title>
    <template v-slot:append>
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn class="mr-4" icon="mdi-account-badge-outline" v-bind="props">
          </v-btn>
        </template>
        <v-list>
          <v-list-item v-for="(item, i) in items" :key="i">
            <v-list-item-title>
              <v-btn
                variant="plain"
                @click="handleLogOut"
                v-if="item.code === 'sign_out'"
              >
                {{ item.title }}
              </v-btn>
              <v-btn variant="plain" @click="handleProfile" v-else>
                {{ item.title }}
              </v-btn>
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script setup>
import { useLoginStore } from "../../store/Login/login";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();

const store = useLoginStore();

function handleLogOut() {
  store.logout().then((res) => {
    if (res.data.message === "success") {
      router.push({ name: "Login" });
      localStorage.setItem("isLoggedIn", "false"); // Persist the isLoggedIn state in browser storage
    }
  });
}

const items = ref([
  { title: "Profile" },
  { title: "Sign Out", code: "sign_out" },
]);

function handleProfile() {
  console.log("profile");
}
</script>

<style>
.logOutBtn {
  background-color: rgb(218, 218, 218);
  color: rgb(46, 46, 46);
  font-weight: 600;
}
</style>