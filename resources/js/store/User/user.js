// Utilities
import { defineStore } from "pinia";
import axios from "axios";

const url = "http://127.0.0.1:8000";

export const useUserStore = defineStore("user", {
    state: () => ({
        users: [],
    }),
    actions: {
        async viewUser() {
            return await new Promise((resolve, reject) => {
                axios
                    .get(`${url}/api/auth/user`, {
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
