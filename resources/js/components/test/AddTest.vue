<template>
    <div class="container">
        <div class=" bg-white mt-5 p-3 shadowBox text-right rtl">
            <!-- <div class="form-group col-12">
                  <label for="">Test Name</label>
                  <input type="text" class="form-control ">
            </div> -->

            <div class="form-group col-12 ">
                <label for="">الفئة</label>
                <select
                    name=""
                    id=""
                    class="form-control"
                    v-model="details.selectedCategory"
                >
                    <option disabled selected value="null"
                        >اختر</option
                    >
                    <option
                        v-for="category in getCategories"
                        value=""
                        :key="category.id"
                        v-bind:value="category.id"
                        >{{ category.category }}</option
                    >
                </select>
            </div>

            <div class="form-group col-12">
                <label for="">الصعوبة</label>
                <select
                    name=""
                    id=""
                    class="form-control"
                    v-model="details.selectedLevel"
                >
                   <option disabled selected value="null"
                        >اختر</option>
                    <option
                        value=""
                        v-for="level in getLevels"
                        :key="level.id"
                        v-bind:value="level.id"
                        >{{ level.level }}</option
                    >
                </select>
            </div>

            <div class="form-group col-12">
                <label for="">عدد الثواني لكل سؤال</label>
                <input
                    type="number"
                    name="seconds"
                    class="form-control "
                    placeholder="for example 20s"
                    v-model="details.second_per_question"
                />
            </div>

            <div class="form-group col-12">
                <label for="">الشرح</label>
                <textarea
                    name=""
                    id=""
                    cols="30"
                    rows="3"
                    class="form-control "
                    placeholder="هذا الاختبار عبارة عن ...موجه لـ...."
                    v-model="details.description"
                ></textarea>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" v-on:click="createTest">
                    انشاء
                </button>
            </div>
        </div>

        <hr />

        <div class="draft">
            <h2 class="text-right">الاختبارات المعلقة</h2>
            <div
                class="bg-white  form-inline p-3 shadowBox mb-2"
                v-for="(test, index) in draftTests"
                :key="test.id"
            >
                <li class="col-4">{{ test.category.category }}</li>
                <li class="col-2">{{ test.level.level }}</li>
                <li class="col-3">{{ test.second_per_question }}s</li>

                <li class="col-1">
                    <span
                        class="badge-danger badge pointer"
                        v-on:click="deleteDraftTest(test.id, index)"
                        >X</span
                    >
                </li>
                <li class="col-2">
                    <router-link
                        :to="{
                            name: 'addQuestion',
                            params: { test_id: test.id }
                        }"
                        >أضافة اسألة</router-link
                    >
                </li>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import axios from "axios";
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            details: {
                selectedLevel: null,
                description: null,
                selectedCategory: null,
                second_per_question: null
            },
            draftTests: []
        };
    },
    methods: {
        ...mapActions("categories", ["getHttpCategories"]),
        ...mapActions("levels", ["getHttpLevels"]),
        createTest() {
            axios
                .post("http://localhost:8000/api/tests", {
                    level: this.details.selectedLevel,
                    description: this.details.description,
                    category: this.details.selectedCategory,
                    second_per_question: this.details.second_per_question
                })
                .then(response => {
                    console.log(response.data);
                    this.appendNewDraftTest(response.data[0]);
                });
        },

        getDraftTest() {
            axios
                .get("http://localhost:8000/api/tests/getDraftTests")
                .then(response => {
                    this.draftTests = response.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        appendNewDraftTest(newTest) {
            this.draftTests.unshift(newTest);
        },
        deleteDraftTest(test_id, index) {
            axios
                .delete(
                    "http://localhost:8000/api/tests/deleteDraftTest/" + test_id
                )
                .then(response => {
                    this.draftTests.splice(index, 1);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    computed: {
        ...mapGetters("categories", ["getCategories"]),
        ...mapGetters("levels", ["getLevels"])
    },
    mounted() {
        this.getHttpCategories();
        this.getHttpLevels();
        this.getDraftTest();
    },
    created() {}
};
</script>
