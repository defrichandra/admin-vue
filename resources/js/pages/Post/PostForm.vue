<template>
  <div class="text-center">
    <v-dialog :model-value="visible" width="auto" persistent>
      <div class="cardForm">
        <v-icon
          icon="mdi-close"
          style="align-self: end"
          @click="$emit('closeModal')"
        ></v-icon>
        <p class="cookieDescription" style="align-self: baseline">Thumbnail</p>
        <input
          id="selectedFile"
          type="file"
          accept="image/*"
          hidden
          @change="$emit('handleFile', $event)"
        />
        <v-text-field
          density="compact"
          variant="outlined"
          :placeholder="thumbnail ? thumbnail : 'Thumbnail'"
          single-line
          hide-details
          readonly
          class="input"
          @click="$emit('triggerFileInput')"
          :model-value="mode === 'Add' ? thumbnail : dataEdit.thumbnail"
        ></v-text-field>
        <p class="cookieDescription mt-3" style="align-self: baseline">Title</p>
        <v-text-field
          density="compact"
          variant="outlined"
          placeholder="Title"
          single-line
          hide-details
          class="input"
          :model-value="mode === 'Add' ? title : dataEdit.title"
          @update:model-value="$emit('handleTitle', $event)"
        ></v-text-field>
        <p class="cookieDescription mt-3" style="align-self: baseline">
          Content
        </p>
        <v-textarea
          id="mytextarea"
          density="compact"
          variant="outlined"
          placeholder="Content"
          single-line
          hide-details
          rows="5"
          cols="50"
          class="input"
          :model-value="mode === 'Add' ? content : dataEdit.content"
          @update:model-value="$emit('handleContent', $event)"
        ></v-textarea>
        <p class="cookieDescription mt-3" style="align-self: baseline">
          Publish Status
        </p>
        <v-select
          density="compact"
          variant="outlined"
          placeholder="Publish Status"
          single-line
          hide-details
          class="input"
          :items="optionStatus"
          item-title="name"
          item-value="code"
          :model-value="
            mode === 'Add' ? publishStatus : dataEdit.publish_status
          "
          @update:model-value="$emit('handleStatus', $event)"
        ></v-select>
        <p class="cookieDescription mt-3" style="align-self: baseline">
          Publish Date
        </p>
        <Datepicker
          placeholder="dd/mm/yyyy"
          format="dd/MM/yyyy"
          :enable-time-picker="false"
          :model-value="mode === 'Add' ? publishDate : dataEdit.publish_date"
          @update:model-value="$emit('handleDate', $event)"
        />
        <div class="buttonContainer">
          <button class="submitButton" @click="$emit('handleSubmit')">
            Save
          </button>
        </div>
      </div>
    </v-dialog>
  </div>
</template>

<script setup>
defineProps([
  "visible",
  "mode",
  "dataEdit",
  "thumbnail",
  "title",
  "content",
  "publishStatus",
  "optionStatus",
  "publishDate",
]);
defineEmits([
  "closeModal",
  "handleFile",
  "triggerFileInput",
  "handleTitle",
  "handleContent",
  "handleStatus",
  "handleDate",
  "handleSubmit",
]);

function triggerDateInput() {
  const dateInput = document.getElementById("dateInput");
  dateInput.style.display = "block";
  dateInput.focus();
  dateInput.click();
}
</script>

<style src="./Post.scss" lang="scss" scoped />