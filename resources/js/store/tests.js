import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

const store = {
    namespaced: true,
    state: {
        tests:[]
    },
    getters: {
        getTests:(state)=>state.tests
    },
    actions: {
           setTests({commit,test}){
                commit('setTest',test);
        }
    },
    mutations: {
        setTest(state,test){
            state.Test = test;
        }
}

}

export default store;
