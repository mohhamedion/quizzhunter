<style>
.view {
    display: block;
}
.thumbnail {
    width: 20px;
}

.noAstyle{
    text-decoration: none;
    color:black
}
.dropdownRight {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;

    float: right;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: right;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
}
</style>
<template>
    <nav id="navbar" class="navbar navbar-expand-lg  " >
        <router-link to="/">
            <a class="navbar-brand text-light"
                ><span class="">Q</span>uizz<span class="">H</span>unter</a
            ></router-link
        >
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto  ">
                <li class="nav-item">
                    <router-link to="/tests">
                        <a class="nav-link text-light" href="#"
                            >الأختبارات</a
                        ></router-link
                    >
                </li>

                <li class="nav-item">
                    <router-link to="/add/test">
                        <a class="nav-link text-light" href="#"
                            >+أكتب اختبارك
                        </a></router-link
                    >
                </li>

                <!-- <div v-if="getUser">
                    <li class="nav-item">
                        <a
                            class="nav-link text-light pointer"
                            v-on:click="logout"
                            >تجسيل الخروج</a
                        >
                    </li>
                </div> -->
            </ul>
        </div>
        <div v-if="getUser" >
            <div    >
                <img class="thumbnail" :src="getUser.image" alt="" />
                <span class="text-white pointer"
                @click="()=>{dropDown=true}"
               v-click-outside="()=>{dropDown=false}" 

                >{{ getUser.firstname }}{{ getUser.lastname }}</span
                >
                <div
                    class="dropdownRight  text-right show"
                    aria-labelledby="dropdownMenuLink"
                    v-if="dropDown"


                >
                    <a class="dropdown-item" href="#">
                        <router-link
                            v-if="getUser"
                            class="text-dark noAstyle"
                            :to="{
                                name: 'profile',
                                params: { user_id: getUser.id }
                            }"
                            >الصفحة الشخصية</router-link
                        ></a
                    >
                    <a class="dropdown-item pointer" v-on:click="logout"
                        >تسجيل الخروج</a
                    >
                </div>
            </div>
        </div>

        <div v-else>
            <li class="nav-item">
                <router-link to="/login">
                    <a class="nav-link text-light" href="#"
                        >Login</a
                    ></router-link
                >
            </li>
        </div>
    </nav>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ClickOutside from 'vue-click-outside'

export default {

    data(){
        return {
            dropDown:false
        }
    },
    computed: {
        ...mapGetters("auth", ["getUser"])
    },

    //  afterMounted() {
    //    console.log('USER',this.getUser)
    //   if (localStorage.getItem("authToken")) {
    //     this.setStatus();
    //   }
    // },

    methods: {
        ...mapActions("auth", ["setStatus", "sendLogoutRequest"]),

       
        logout() {
            this.sendLogoutRequest().then(() => {
                this.$router.push("/");
            });
        }
    },
    directives: {
    ClickOutside
  }
};
</script>
