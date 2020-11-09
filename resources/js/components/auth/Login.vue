<style>
.center {
    margin-left: 25%;
}
.bgprimary {
    background: #007bff;
}
</style>

<template>
    <div class="container ">
        <div class="mt-4 ">
            <div class="col-6 center  bg-white p-4 shadowBox ">
                <h1 class="font175 ">Login</h1>

                <div class="form-group">
                    <label for="">Email</label>
                    <input
                        type="text"
                        placeholder="Email"
                        v-model="info.email"
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="">password</label>
                    <input
                        type="password"
                        placeholder="password"
                        v-model="info.password"
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <input
                        type="submit"
                        value="Login"
                        v-on:click="login"
                        class="btn bgprimary text-white"
                    />
                </div>

                <div>
                    <router-link to="/register"
                        ><a href="">Don't have account?</a></router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapGetters, mapActions } from "vuex";

export default {
    methods: {
        ...mapActions("auth", ["setUserData", "sendLoginRequest"]),
        login() {
            this.sendLoginRequest(this.info).then(()=>{
                this.$router.push({ name: "tests" });
            }).catch(e=>{
                console.log(e)
            });
        },
        
    },

    data() {
        return {
            info: {
                email: null,
                password: null
            }
        };
    }
};
</script>
