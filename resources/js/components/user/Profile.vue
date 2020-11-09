<style scoped>
.avatar_image {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    border: var(--best-border);
}
.lineButtom {
    border-bottom: 0.15em solid #4d96e4;
}
a {
    color: inherit;
    text-decoration: none;
}
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-3 mt-5">
                <img
                    class="avatar_image"
                    src="https://cdn.proghub.ru/avatars/cd728b24a9bb103b95644c04fd1e4a3c.png"
                    alt=""
                />
                <h3 class="weight300 font175">
                    {{ user.firstname }} {{ user.lastname }}
                </h3>
            </div>

            <div class="col-9 mt-5">
                <div>
                    <div class="font11">
                        <router-link :to="{ name: 'profileTestResult' }">
                            <span
                                class="pointer weight300  mr-4 "
                                @mouseover="
                                    e => {
                                        e.target.classList.add('lineButtom');
                                    }
                                "
                                @mouseleave="
                                    e => {
                                        e.target.classList.remove('lineButtom');
                                    }
                                "
                                >Test Results</span
                            ></router-link
                        >
                        <router-link :to="{ name: 'createdTests' }">
                            <span
                                class="pointer weight300  mr-4 "
                                @mouseover="
                                    e => {
                                        e.target.classList.add('lineButtom');
                                    }
                                "
                                @mouseleave="
                                    e => {
                                        e.target.classList.remove('lineButtom');
                                    }
                                "
                                >created tests</span
                            >
                        </router-link>
                    </div>
                    <hr />

                    <router-view
                        :key="$route.path"
                        :tests="tests"
                    ></router-view>
                    <!-- 
                                                 <div class="col-12  ">
                                                <div class="row">
                                                        <div v-for="test in tests" class="ml-5">
                                                                <test-card :test="test"  ></test-card>    
                                                        </div>
                                                </div>
                                            </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            user: {},
            tests: []
        };
    },
    methods: {
        async getUser() {
            const response = await axios.get(
                "http://localhost:8000/api/profile/" +
                    this.$route.params.user_id
            );
            this.user = response.data;
            this.tests = response.data.tests;
        }
    },

    // created(){
    //     this.getUser();
    // },
    beforeMount() {
        this.getUser();
    }
};
</script>
