 

<template>
    
    <div class="container ">
        

        <div class="mt-4 ">

        <div class="col-6 center  bg-white p-4 shadowBox " >
                    <h1 class="font175 ">Register</h1>

          

                    <div class="form-group">
                    <label for="">Firstname</label>
                    <input type="text" placeholder="firstname" class="form-control" v-model="info.firstname">
                </div>
                    <div class="form-group">
                    <label for="">Lasntame</label>
                    <input type="text" placeholder="lastname" class="form-control" v-model="info.lastname">
                </div>

                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="Email" placeholder="Email" class="form-control" v-model="info.email">
                </div>

                <div class="form-group">
                    <label for="">password</label>
                    <input type="password" placeholder="password" class="form-control" v-model="info.password">
                </div>

                <div class="form-group">
                    <label for="">re-password</label>
                    <input type="password" placeholder="password" class="form-control" v-model="info.c_password">
                </div>

                
                <div class="form-group">
                  
                    <input type="submit" value="Login" class="btn bgprimary text-white" v-on:click="register" >
                </div>

                <div>
                    <router-link to="/login"><a href="">Already have account?</a></router-link>
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
        ...mapActions("auth", ["setStatus", "sendRegisterRequest"]),
        register() {
           
            this.sendRegisterRequest(this.info).then(()=>{
                console.log('send')
                this.$router.push({ name: "tests" });
            }).catch(e=>{
                console.log(e)
            });
        }
    },
    data() {
        return {
            info: {
                firstname: null,
                lastname: null,
                email: null,
                password: null,
                c_password:null,

            }
        };
    }
};
</script>