<template>
    <div class="container ">
        <div class="row mt-5">
            <div class="col-8  ">
                <div class="row">
                    <div  v-for="test in tests" :key="test.id">
                        <div class="ml-5 ">
                            <test-card :test="test" :key="test.id"></test-card>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4  ">
                <div class="bg-light p-3 border">
                    <div class="form-group">
                        <select name="" id="" class="form-control" v-model="search.level" @change="getAllTests" >
                                 <option disabled selected value="null"  >Level</option  >
                            <option value="" v-for="level in getLevels" :key="level.id" v-bind:value="level.id">{{level.level}}</option>
                    
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="" id="" class="form-control" v-model="search.category" @change="getAllTests">
                                 <option disabled selected value="null"  >Category</option  >

                            <option
                                v-for="category in getCategories"
                                :key="category.id"
                                :value="category.id"
                                v-bind:value="category.id"
                                >{{ category.category }}</option
                            >
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            tests: [
        
            ],
            search:{
                level:null,
                category:null
            }
        };
    },
    methods: {
        ...mapActions("categories", ["getHttpCategories"]),
        ...mapActions("levels", ["getHttpLevels"]),
        getAllTests(){

            axios.get(`http://localhost:8000/api/tests?level=${this.search.level}&category=${this.search.category}`,{
               
            }).then(response=>{
                    this.tests = response.data;
                    console.log(this.tests)
            })
        }
    },
    computed:{
              ...mapGetters("categories", ["getCategories"]),
              ...mapGetters("levels", ["getLevels"]),

    },
    

    mounted() {
        this.getHttpCategories();
        this.getHttpLevels();
        this.getAllTests();
    }
};
</script>
