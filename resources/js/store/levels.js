import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

const store = {
    namespaced: true,
    state: {
        levels:[]
    },
    getters: {
        getLevels:(state)=>state.levels
    },
    actions: {
           getHttpLevels({commit}){
     
            axios.get('http://localhost:8000/api/levels').then((response)=>{
                    commit('setLevels',response.data);
            });

        }
    },
    mutations: {
        setLevels(state,levels){
            state.levels = levels;
        }
}

}

export default store;
