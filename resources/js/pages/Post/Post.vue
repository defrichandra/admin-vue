<template>
  <div class="articles">
    <div class="container">
      <div class="section-heading">
        <h2>Latest Articles</h2>
        <v-btn variant="outlined" class="logOutBtn" @click="openModal('Add')">
          Add
        </v-btn>
      </div>
      <div class="articles-grid">
        <div class="article" v-for="(item, index) in store.posts" :key="index">
          <div class="article-image">
            <img :src="item.imageSrc" alt="" />
          </div>
          <div class="article-text">
            <div class="buttonContainer">
              <v-tooltip text="Edit" location="bottom">
                <template v-slot:activator="{ props }">
                  <button
                    v-bind="props"
                    class="acceptButton"
                    @click="openModal('Edit', item)"
                  >
                    <v-icon icon="mdi-note-edit"></v-icon>
                  </button>
                </template>
              </v-tooltip>

              <v-tooltip text="Delete" location="bottom">
                <template v-slot:activator="{ props }">
                  <button
                    v-bind="props"
                    class="declineButton"
                    @click="openModalDelete(item)"
                  >
                    <v-icon icon="mdi-delete-outline"></v-icon>
                  </button>
                </template>
              </v-tooltip>
            </div>
            <div class="article-author">
              <span>By Defri Chandra</span>
            </div>
            <div class="article-title">
              <a href=""
                ><h3>{{ item.title }}</h3></a
              >
            </div>
            <div class="article-description">
              <p>
                {{ item.content }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <ModalDelete
    :visible="modalDelete"
    @close-modal="closeModalDelete"
    @handleDelete="handleDelete"
  />

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
import ModalDelete from "../../components/ModalDelete.vue";

onMounted(() => {
  loadPost();
});

const store = usePostStore();

//View
function loadPost() {
  store.viewPost().then((res) => {
    store.posts = res.data;

    store.posts.map((item) => {
      store.showImage(item.file).then((response) => {
        const blob = new Blob([response.data], { type: "image/*" });
        item.imageSrc = URL.createObjectURL(blob);
      });
    });
  });
}
//View

//Modal Form
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
  selectedData.value = item;

  selectedData.value.publish_date = moment(
    selectedData.value.publish_date,
    "DD/MM/YYYY"
  ).format("YYYY-MM-DD");
}
//Modal Form

// Submit
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

  const formData = new FormData();
  formData.append("file", file);

  store.uploadFile(formData).then((res) => {
    let str = res.data.filePath;

    //for file path
    thumbnailPath.value =
      modeForm.value === "Add"
        ? (thumbnailPath.value = str.substring(str.lastIndexOf("/") + 1))
        : (selectedData.value.file = str.substring(str.lastIndexOf("/") + 1));
  });
}

function handleTitle(modelValue) {
  modeForm.value === "Add"
    ? (title.value = modelValue)
    : (selectedData.value.title = modelValue);
}

function handleContent(modelValue) {
  modeForm.value === "Add"
    ? (content.value = modelValue)
    : (selectedData.value.content = modelValue);
}

function handleStatus(modelValue) {
  modeForm.value === "Add"
    ? (publishStatus.value = modelValue)
    : (selectedData.value.publish_status = modelValue);
}

function handleDate(modelValue) {
  console.log(modelValue);
  modeForm.value === "Add"
    ? (publishDate.value = modelValue)
    : (selectedData.value.publish_date = modelValue);
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
          publishDate: moment(publishDate.value, "YYYY-MM-DD").format(
            "DD/MM/YYYY"
          ),
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
// Submit

//Update
function handleUpdate(item) {
  let request = {
    file: item.file,
    thumbnail: item.thumbnail,
    title: item.title,
    content: item.content,
    publishStatus: item.publish_status,
    publishDate: moment(item.publish_date, "YYYY-MM-DD").format("DD/MM/YYYY"),
  };

  store.updatePost(item.id, request).then((res) => {
    if (res.data.message === "success") {
      closeModal();
      loadPost();
    }
  });
}
//Update

//Delete
const modalDelete = ref(false);
const idDelete = ref(null);

function openModalDelete(item) {
  modalDelete.value = true;
  idDelete.value = item.id;
}

function closeModalDelete() {
  modalDelete.value = false;
}

function handleDelete() {
  store.deletePost(idDelete.value).then((res) => {
    if (res.data.message === "success") {
      closeModalDelete();
      loadPost();
    }
  });
}
//Delete
</script>

<style src="./Post.scss" lang="scss" scoped />
