<template>
  <v-navigation-drawer
    :model-value="visible"
    class="bg-deep-purple"
    theme="dark"
    permanent
  >
    <v-list :items="itemsSideBar"></v-list>
  </v-navigation-drawer>
</template>
  
<script setup>
defineProps(["visible", "itemsSideBar"]);
</script>
  
  <style lang="scss" scoped>
</style>