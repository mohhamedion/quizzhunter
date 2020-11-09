import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

const store = {
    namespaced: true,
    state: {
        logged: false,
        user: null
    },
    getters: {
        getUser: state => {
            return state.user;
        }
    },
    actions: {

        setStatus({ commit }) {
            commit("setStatus");
        },



        async sendLoginRequest({ commit }, formData) {
            const link = "http://localhost:8000/" + "api/login";
            if (!localStorage.getItem("authToken")) {
                const response = await axios.post(link, formData);
                if (response.data.token) {
                    localStorage.setItem("authToken", response.data.token);
                    commit("setStatus");
                    commit("setUserData", response.data.user);
                } else {
                    throw Error({ error: "422" });
                }
            }
        },



        async sendRegisterRequest({ commit }, formData) {
            const link = "http://localhost:8000/" + "api/register";
            if (!localStorage.getItem("authToken")) {
                const response = await axios.post(link, formData);
                if (response.data.token) {
                    localStorage.setItem("authToken", response.data.token);

                    commit("setStatus");
                    commit("setUserData", response.data);

                } else {
                    throw Error({ error: response });
                }
            }
        },



        sendLogoutRequest({ commit }) {
            if (localStorage.getItem("authToken")) {
                localStorage.removeItem("authToken");
                commit("setStatus");
                commit("setUserData", null);
            }
        },



       async getUserData({ commit }) {
                try {
                    const response = await axios
                    .get("http://localhost:8000/api/user");
                    commit("setUserData", response.data); 
                } catch (error) {
                    localStorage.removeItem("authToken");
                    
                } 

        }
    },
    mutations: {
        setStatus: state => {
            if (localStorage.getItem("authToken")) {
                state.logged = true;
            } else {
                state.logged = false;
            }
        },
        setUserData: (state, user) => {
            state.user = user;
        }
    }
};

export default store;
