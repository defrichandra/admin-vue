<template>
  <v-dialog :model-value="visible" persistent>
    <div class="d-flex align-center flex-column">
      <v-card class="deleteCard">
        <v-card-title class="card-title mb-4"> Delete </v-card-title>
        <v-card-text class="card-text">
          Are you sure want to delete this Data ?
        </v-card-text>
        <v-card-actions class="cardBtn">
          <v-btn
            variant="tonal"
            class="acceptButton"
            @click="$emit('closeModal')"
          >
            <p>No</p>
          </v-btn>
          <v-btn
            variant="tonal"
            class="declineButton"
            @click="$emit('handleDelete')"
          >
            <p>Yes</p>
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </v-dialog>
</template>

<script setup>
defineProps(["visible"]);
defineEmits(["closeModal", "handleDelete"]);
</script>

<style lang="scss" scoped>
.deleteCard {
  padding: 28px;
  border-radius: 20px;
  gap: 32px;
}

.card-title {
  font-family: Roboto;
  font-size: 24px;
  font-weight: 500;
  line-height: 32px;
  letter-spacing: 0em;
  text-align: center;
}

.cardBtn {
  display: flex;
  gap: 16px;
  flex-direction: row;
  justify-content: center;
}

.card-text {
  font-family: Roboto;
  font-size: 20px;
  font-weight: 400;
  line-height: 28px;
  letter-spacing: 0em;
  text-align: start;
  color: #64748b;
}

.acceptButton {
  width: 80px;
  height: 30px;
  background-color: #7b57ff;
  transition-duration: 0.2s;
  border: none;
  color: rgb(241, 241, 241);
  cursor: pointer;
  font-weight: 600;
  border-radius: 20px;
}

.declineButton {
  width: 80px;
  height: 30px;
  background-color: rgb(218, 218, 218);
  transition-duration: 0.2s;
  color: rgb(46, 46, 46);
  border: none;
  cursor: pointer;
  font-weight: 600;
  border-radius: 20px;
}

.declineButton:hover {
  background-color: #ebebeb;
  transition-duration: 0.2s;
}

.acceptButton:hover {
  background-color: #9173ff;
  transition-duration: 0.2s;
}
</style>