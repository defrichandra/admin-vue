<template>
  <v-navigation-drawer
    :model-value="visible"
    class="bg-deep-purple"
    theme="dark"
    permanent
  >
    <v-list flat dense nav class="mt-2">
      <v-list-group color="primary" mandatory>
        <v-list-item
          v-for="item in itemsSideBar"
          :key="item.title"
          :to="item.to"
          :title="item.title"
          :prepend-icon="item.icon"
          dense
        >
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>
  
<script setup>
defineProps(["visible", "itemsSideBar", "link"]);
</script>
  
<style lang="scss" scoped>
.v-list {
  .v-list-item:hover {
    background-color: gray;
    &:before {
      opacity: 0;
    }
  }
  // .v-list-item:hover .v-list-item__icon {
  // .v-icon {
  //   color: rgba($primary, 0.8) !important;
  // }
  // }
  .link-item {
    cursor: pointer;
  }
}
</style>