<template>
  <v-navigation-drawer
    :model-value="visible"
    class="bg-deep-purple"
    theme="dark"
    permanent
  >
    <v-list flat dense nav class="mt-2">
      <v-list-item-group color="primary" mandatory>
        <v-list-item
          v-for="item in itemsSideBar"
          :key="item.title"
          dense
          :to="item.to"
          link
        >
          <v-list-item-icon class="ml-4 mr-4">
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-title>{{ item.title }}</v-list-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
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