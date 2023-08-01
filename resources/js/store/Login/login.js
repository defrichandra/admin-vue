// Utilities
import { defineStore } from "pinia";
import axios from "axios";

const url = "http://127.0.0.1:8000";

export const useLoginStore = defineStore("app", {
    state: () => ({
        //
        drawer: true,
    }),
    actions: {
        initialize() {
            // Retrieve the isLoggedIn state from browser storage on store initialization
            const isLoggedIn = localStorage.getItem("isLoggedIn");
            const token = localStorage.getItem("token");
            const user = localStorage.getItem("user");

            return { isLoggedIn, token, user };
        },
        async register(request) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`${url}/api/auth/register`, request)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async login(request) {
            return await new Promise((resolve, reject) => {
                axios
                    .post(`${url}/api/auth/login`, request)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async logout() {
            return await new Promise((resolve, reject) => {
                axios
                    .post(
                        `${url}/api/auth/logout`,
                        {},
                        {
                            headers: {
                                Authorization: `Bearer ${localStorage.token}`,
                            },
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
    },
});
