<template>
  <div class="d-flex flex-row justify-end mr-16">
    <v-btn variant="outlined" class="logOutBtn" @click="openModal('Add')">
      Add
    </v-btn>
  </div>

  <div class="content">
    <div class="card" v-for="(item, index) in store.posts" :key="index">
      <img :src="item.imageSrc" class="thumbnailStyle" />

      <p class="cookieHeading">{{ item.title }}</p>

      <p class="cookieDescription">
        {{ item.publish_status }}
      </p>

      <p class="cookieDescription">
        {{ item.publish_date }}
      </p>

      <p class="cookieDescription">
        {{ item.content }}
      </p>

      <div class="buttonContainer">
        <!-- <button class="acceptButton" @click="handleUpdate(item.id)">
          Edit
        </button> -->
        <button class="acceptButton" @click="openModal('Edit', item)">
          Edit
        </button>
        <button class="declineButton" @click="handleDelete(item.id)">
          Delete
        </button>
      </div>
    </div>
  </div>

  <PostForm
    :visible="postForm"
    :mode="modeForm"
    @close-modal="closeModal"
    :dataEdit="selectedData"
    :thumbnail="thumbnail"
    :title="title"
    :content="content"
    :publishStatus="publishStatus"
    :optionStatus="status"
    :publishDate="publishDate"
    @handleFile="handleFile"
    @triggerFileInput="triggerFileInput"
    @handleTitle="handleTitle"
    @handleContent="handleContent"
    @handleStatus="handleStatus"
    @handleDate="handleDate"
    @handleSubmit="handleSubmit"
  />
</template>

<script setup>
import { usePostStore } from "../../store/Post/post";
import { ref, onMounted } from "vue";
import PostForm from "./PostForm.vue";
import moment from "moment";

onMounted(() => {
  loadPost();
});

const store = usePostStore();

//View
function loadPost() {
  store.viewPost().then((res) => {
    console.log(res.data);
    store.posts = res.data;

    store.posts.map((item) => {
      console.log(item.publish_date);
      item.publish_date = moment(item.publish_date, "YYYY-MM-DD").format(
        "DD/MM/YYYY"
      );
      console.log(item.publish_date);

      store.showImage(item.file).then((response) => {
        const blob = new Blob([response.data], { type: "image/*" });
        item.imageSrc = URL.createObjectURL(blob);
      });
    });
  });
}
//View

//Modal
const postForm = ref(false);
const modeForm = ref("");
const selectedData = ref({});

function closeModal() {
  postForm.value = false;
  clear();
}

function clear() {
  thumbnail.value = "";
  title.value = "";
  content.value = "";
  publishStatus.value = "";
  publishDate.value = "";
  selectedData.value = {};
}

function openModal(mode, item) {
  postForm.value = true;
  modeForm.value = mode;
  console.log(modeForm.value);
  selectedData.value = item;
}
//Modal

// submit
const thumbnail = ref("");
const thumbnailPath = ref("");
const title = ref("");
const content = ref("");
const publishStatus = ref("");
const status = ref([
  {
    code: "STATUS_DRAFT",
    name: "Draft",
  },
  {
    code: "STATUS_PUBLISH",
    name: "Publish",
  },
]);
const publishDate = ref("");

function triggerFileInput() {
  document.getElementById("selectedFile").click();
}

function handleFile(event) {
  let file = event.target.files[0];

  //for file name
  modeForm.value === "Add"
    ? (thumbnail.value = file.name)
    : (selectedData.value.thumbnail = file.name);

  modeForm.value === "Add"
    ? console.log(thumbnail.value)
    : console.log(selectedData.value.thumbnail);

  const formData = new FormData();
  formData.append("file", file);

  store.uploadFile(formData).then((res) => {
    let str = res.data.filePath;

    //for file path
    thumbnailPath.value =
      modeForm.value === "Add"
        ? (thumbnailPath.value = str.substring(str.lastIndexOf("/") + 1))
        : (selectedData.value.file = str.substring(str.lastIndexOf("/") + 1));

    modeForm.value === "Add"
      ? console.log(thumbnailPath.value)
      : console.log(selectedData.value.file);
  });
}

function handleTitle(modelValue) {
  modeForm.value === "Add"
    ? (title.value = modelValue)
    : (selectedData.value.title = modelValue);

  modeForm.value === "Add"
    ? console.log(title.value)
    : console.log(selectedData.value.title);
}

function handleContent(modelValue) {
  modeForm.value === "Add"
    ? (content.value = modelValue)
    : (selectedData.value.content = modelValue);

  modeForm.value === "Add"
    ? console.log(content.value)
    : console.log(selectedData.value.content);
}

function handleStatus(modelValue) {
  modeForm.value === "Add"
    ? (publishStatus.value = modelValue)
    : (selectedData.value.publish_status = modelValue);

  modeForm.value === "Add"
    ? console.log(publishStatus.value)
    : console.log(selectedData.value.publish_status);
}

function handleDate(modelValue) {
  console.log(modelValue);
  // modeForm.value === "Add"
  //   ? (publishDate.value = modelValue)
  //   : (selectedData.value.publish_date = moment(
  //       modelValue,
  //       "YYYY-MM-DD"
  //     ).format("DD/MM/YYYY"));

  publishDate.value = moment(modelValue, "MM/DD/YYYY").format("DD/MM/YYYY");
  console.log(publishDate.value);
  selectedData.value.publish_date = moment(modelValue, "MM/DD/YYYY").format("DD/MM/YYYY");
  console.log(selectedData.value.publish_date);
}

function handleSubmit() {
  modeForm.value === "Add"
    ? store
        .savePost({
          file: thumbnailPath.value,
          thumbnail: thumbnail.value,
          title: title.value,
          content: content.value,
          publishStatus: publishStatus.value,
          publishDate: publishDate.value,
        })
        .then((res) => {
          console.log("response", res);
          if (res.data.message === "success") {
            closeModal();
            loadPost();
          }
        })
    : handleUpdate(selectedData.value);
}
// submit

//Update
function handleUpdate(item) {
  console.log(item);
  let request = {
    file: item.file,
    thumbnail: item.thumbnail,
    title: item.title,
    content: item.content,
    publishStatus: item.publish_status,
    publishDate: item.publish_date,
  };
  console.log(request);

  // store.updatePost(item.id, request).then((res) => {
  //   console.log("res", res);
  //   loadPost();
  // });
}
//Update

//Delete
function handleDelete(id) {
  store.deletePost(id).then((res) => {
    console.log("res", res);
    loadPost();
  });
}

//Delete
</script>

<style src="./Post.scss" lang="scss" scoped />
