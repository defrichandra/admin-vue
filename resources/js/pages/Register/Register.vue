<template>
  <div class="content">
    <form @submit.prevent="handleRegister" class="form">
      <div class="title">Welcome</div>
      <div class="subtitle">Let's create your account!</div>

      <div class="input-container ic1">
        <input
          placeholder="Name"
          type="text"
          class="input"
          id="name"
          v-model="name"
        />
      </div>

      <div class="input-container ic2">
        <input
          placeholder="Email"
          type="email"
          class="input"
          id="email"
          v-model="email"
        />
      </div>
      <div class="input-container ic2">
        <input
          placeholder="Password"
          type="password"
          class="input"
          id="password"
          v-model="password"
        />
      </div>
      <div class="input-container ic2">
        <input
          placeholder="Password"
          type="password"
          class="input"
          id="confirmPassword"
          v-model="confirmPassword"
        />
      </div>
      <button class="submit mb-2" type="text">submit</button>
    </form>
  </div>
  <Error
    :showSnackbar="showSnackbar"
    :snackbarColor="snackbarColor"
    :snackbarMsg="snackbarMsg"
  />
</template>

<script setup>
import { ref } from "vue";
import { useLoginStore } from "../../store/Login/login";
import Error from "../../components/Error.vue";
import { useRouter } from "vue-router";

const store = useLoginStore();
const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const showSnackbar = ref(false);
const snackbarColor = ref("");
const snackbarMsg = ref("");

function handleRegister() {
  let request = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: confirmPassword.value
  };

  store
    .register(request)
    .then((res) => {
      console.log(res);
      if (res.data.message === "success") {
        router.push({ name: "Login" });
      }
    })
    .catch((err) => {
      console.log(err.response.data);
      showSnackbar.value = true;
      snackbarColor.value = "red";
      snackbarMsg.value = err.response.data.message;
    });

  showSnackbar.value = false;
}
</script>

<style src="./Register.scss" lang="scss" scoped />