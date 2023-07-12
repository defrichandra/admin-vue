// Utilities
import { defineStore } from "pinia";
import axios from "axios";

const url = "http://127.0.0.1:8000";

export const usePostStore = defineStore("post", {
    state: () => ({
        posts: [],
    }),
    actions: {
        async uploadFile(formData) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`${url}/api/post/upload`, formData, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                            "Content-Type": "multipart/form-data",
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async showImage(fileName) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`${url}/api/post/files/${fileName}`, {
                        responseType: "arraybuffer",
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async searchPost(request) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`${url}/api/post/search_post`, request, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async savePost(request) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`${url}/api/post/save_post`, request, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async viewPost() {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`${url}/api/post/view_post`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async updatePost(id, request) {
            return await new Promise((resolve, reject) => {
                axios
                    .put(`${url}/api/post/update_post/${id}`, request, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async deletePost(id) {
            return await new Promise((resolve, reject) => {
                axios
                    .delete(`${url}/api/post/delete_post/${id}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.token}`,
                        },
                        validateStatus: function (status) {
                            return status == 200;
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
    },
});
