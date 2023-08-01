<template>
  <v-snackbar :model-value="showSnackbar" :color="snackbarColor" vertical>
    {{ snackbarMsg }}
    <template v-slot:action="{ attrs }">
      <v-btn text small v-bind="attrs" @click="showSnackbar = false"> X </v-btn>
    </template>
  </v-snackbar>
</template>

<script setup>
defineProps(["showSnackbar", "snackbarColor", "snackbarMsg"]);
</script>

<style lang="scss" scoped></style>