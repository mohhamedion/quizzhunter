<style>
.view {
    display: block;
}
.thumbnail {
    width: 20px;
}
</style>
<template>
    <nav id="navbar" class="navbar navbar-expand-lg  ">
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
                            >+أكتب اختبارك  </a
                        ></router-link
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
       <div v-if="getUser">
                <img class="thumbnail" :src="getUser.image" alt="" />
                <router-link
                    v-if="getUser"
                    :to="{ name: 'profile', params: { user_id: getUser.id } }"
                    ><span class="text-white"
                        >{{ getUser.firstname }}{{ getUser.lastname }}</span
                    ></router-link
                >
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
export default {
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

        dropDown(e) {
            this.$refs["login"].classList.add("view");
        },
        logout() {
            this.sendLogoutRequest().then(() => {
                this.$router.push("/");
            });
        }
    }
};
</script>
