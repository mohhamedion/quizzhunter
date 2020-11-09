import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

const store = {
    namespaced: true,
    state: {
        categories:[]
    },
    getters: {
        getCategories:(state)=>state.categories
    },
    actions: {
           getHttpCategories({commit}){
     
            axios.get('http://localhost:8000/api/categories').then((response)=>{
                    commit('setCategories',response.data);
            });

        }
    },
    mutations: {
        setCategories(state,categories){
            state.categories = categories;
        }
}

}

export default store;
