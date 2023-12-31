<template>
  <div class="articles">
    <div class="container">
      <div class="section-heading">
        <h2>Latest Articles</h2>
      </div>
      <div class="d-flex flex-row mb-8">
        <v-col cols="4" class="px-0">
          <v-text-field
            density="compact"
            variant="outlined"
            placeholder="Search"
            single-line
            hide-details
            class="input"
            v-model="searchValue"
          ></v-text-field>
        </v-col>
        <v-col class="mt-1 mx-3">
          <v-btn
            variant="outlined"
            class="declineButton text-none"
            @click="handleSearch(searchValue)"
          >
            Search
          </v-btn>
        </v-col>
        <v-col class="mt-1 text-end">
          <v-btn
            variant="outlined"
            class="acceptButton text-none"
            @click="openModal('Add')"
          >
            Add
          </v-btn>
        </v-col>
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
              <span>By {{ item.updated_by ? item.updated_by : item.created_by }} ({{ item.publish_date }})</span>
            </div>
            <div class="article-title">
              <a href="">
                <h3>{{ item.title }}</h3>
              </a>
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

  <Error
    :showSnackbar="showSnackbar"
    :snackbarColor="snackbarColor"
    :snackbarMsg="snackbarMsg"
  />
</template>

<script setup>
import { usePostStore } from "../../store/Post/post";
import { ref, onMounted } from "vue";
import PostForm from "./PostForm.vue";
import moment from "moment";
import ModalDelete from "../../components/ModalDelete.vue";
import Error from "../../components/Error.vue";

onMounted(() => {
  loadPost();
});

const store = usePostStore();

// Search
const searchValue = ref("");

function handleSearch() {
  let request = {
    searchValue: searchValue.value,
  };

  store.searchPost(request).then((res) => {
    if (res.data.message === "success") {
      store.posts = res.data.data;

      store.posts.map((item) => {
        store.showImage(item.file).then((response) => {
          const blob = new Blob([response.data], { type: "image/*" });
          item.imageSrc = URL.createObjectURL(blob);
        });
      });
    }
  });
}
// Search

//View
function loadPost() {
  store.viewPost().then((res) => {
    store.posts = res.data.data;

    store.posts.map((item) => {
      store.showImage(item.file).then((response) => {
        const blob = new Blob([response.data], { type: "image/*" });
        item.imageSrc = URL.createObjectURL(blob);
      });

      item.publish_date = moment(item.publish_date).format("DD/MM/YYYY");
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

  if (modeForm.value === "Edit") {
    selectedData.value = item;

    item.publish_date = moment(item.publish_date, "DD/MM/YYYY").format(
      "YYYY-MM-DD"
    );
  }
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
  modeForm.value === "Add" ? handleAdd() : handleUpdate(selectedData.value);
}
// Submit

// Error
const showSnackbar = ref(false);
const snackbarColor = ref("");
const snackbarMsg = ref("");
// Error

// Add
function handleAdd() {
  store
    .savePost({
      file: thumbnailPath.value,
      thumbnail: thumbnail.value,
      title: title.value,
      content: content.value,
      publishStatus: publishStatus.value,
      publishDate: moment(publishDate.value).format("YYYY-MM-DD"),
      publishBy: localStorage.user,
    })
    .then((res) => {
      console.log("response", res);
      if (res.data.message === "success") {
        closeModal();
        loadPost();
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
// Add

//Update
function handleUpdate(item) {
  let request = {
    file: item.file,
    thumbnail: item.thumbnail,
    title: item.title,
    content: item.content,
    publishStatus: item.publish_status,
    publishDate: moment(item.publish_date).format("YYYY-MM-DD"),
    rewriteBy: localStorage.user,
  };

  store
    .updatePost(item.id, request)
    .then((res) => {
      if (res.data.message === "success") {
        closeModal();
        loadPost();
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
