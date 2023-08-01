<template>
  <div class="card mt-12">
    <div class="card-article">
      <h2>Profile Information</h2>
      <p>Update your account's profile information and email address.</p>

      <div>
        <p class="label-card">Name</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="Name"
          single-line
          hide-details
          class="input"
          v-model="name"
        ></v-text-field>
        <p class="label-card">Email</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="Email"
          single-line
          hide-details
          class="input"
          v-model="email"
        ></v-text-field>
      </div>

      <div class="mt-8">
        <v-btn
          variant="outlined"
          class="saveBtn text-none"
          @click="openModal('Add')"
        >
          Save
        </v-btn>
      </div>
    </div>
  </div>

  <div class="card mt-12">
    <div class="card-article">
      <h2>Update Password</h2>
      <p>
        Ensure your account is using a long, random password to stay secure.
      </p>

      <div>
        <p class="label-card">Password</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="Password"
          single-line
          hide-details
          class="input"
          :append-inner-icon="visiblePass ? 'mdi-eye-off' : 'mdi-eye'"
          @click:append-inner="visiblePass = !visiblePass"
          :type="visiblePass ? 'text' : 'password'"
          prepend-inner-icon="mdi-lock-outline"
          v-model="password"
        ></v-text-field>
        <p class="label-card">New Password</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="New Password"
          single-line
          hide-details
          class="input"
          :append-inner-icon="visibleNewPass ? 'mdi-eye-off' : 'mdi-eye'"
          @click:append-inner="visibleNewPass = !visibleNewPass"
          :type="visibleNewPass ? 'text' : 'password'"
          prepend-inner-icon="mdi-lock-outline"
          v-model="newPassword"
        ></v-text-field>
        <p class="label-card">Confirm Password</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="Confirm Password"
          single-line
          hide-details
          class="input"
          :append-inner-icon="visibleConfPass ? 'mdi-eye-off' : 'mdi-eye'"
          @click:append-inner="visibleConfPass = !visibleConfPass"
          :type="visibleConfPass ? 'text' : 'password'"
          prepend-inner-icon="mdi-lock-outline"
          v-model="confirmPassword"
        ></v-text-field>
      </div>

      <div class="mt-8">
        <v-btn
          variant="outlined"
          class="saveBtn text-none"
          @click="openModal('Add')"
        >
          Save
        </v-btn>
      </div>
    </div>
  </div>

  <div class="card mt-12">
    <div class="card-article">
      <h2>Delete Account</h2>
      <p>
        Once your account is deleted, all of its resources and data will be
        permanently deleted. Before deleting your account, please download any
        data or information that you wish to retain.
      </p>
      <div class="mt-8">
        <v-btn variant="outlined" class="deleteBtn" @click="openModal('Add')">
          Delete Account
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useProfileStore } from "../../store/Profile/profile";

onMounted(() => {
  loadProfile();
});

const visiblePass = ref(false);
const visibleNewPass = ref(false);
const visibleConfPass = ref(false);

const store = useProfileStore();

const name = ref("");
const email = ref("");

function loadProfile() {
  store.viewProfile().then((res) => {
    console.log(res);
    // store.profile = res.data.user;
    name.value = res.data.user.name;
    email.value = res.data.user.email;
  });
}

const password = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
</script>

<style src="./Profile.scss" lang="scss" scoped />