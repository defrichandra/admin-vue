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
                    .get(
                        `${url}/api/post/files/${fileName}`,
                        { responseType: "arraybuffer" },
                        {
                            validateStatus: function (status) {
                                return status == 200;
                            },
                        }
                    )
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
        async viewPost(request) {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`${url}/api/post/view_post`, request, {
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
