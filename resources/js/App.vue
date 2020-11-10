<style >
#navbar {
    background: #24292e;
}
#welcome {
    margin-top: 0px;
    background: url(https://cdn.proghub.ru/home/background.svg), #2b3137;
    background-position: center 10%;
    background-size: cover;
    height: 500px;
}

.font175 {
    font-size: 1.75em;
}

.font11 {
    font-size: 1.1em;
}
.weight300 {
    font-weight: 300;
}

#welcomeContent {
    padding-top: 150px;
}

#line {
    background: transparent
        linear-gradient(117deg, var(--blue), var(--cyan), var(--blue)) repeat
        scroll 0 0/200% 200%;
    padding-top: 0.75em;
}

.imgAbout {
    height: 122px;
    width: 200px;
}

.ranbow_badge {
    background: linear-gradient(90deg, #3a6186, #89253e);
}

#bestRating {
    margin-top: 0px;
    background: url(https://cdn.proghub.ru/home/background.svg), #2b3137;
    background-position: center 10%;
    background-size: cover;
    height: 500px;
}

.bestRatingColor {
    background-color: rgba(0, 0, 0, 0.2);
}
</style>

<template>
    <div>
        <navigator></navigator>

        <router-view></router-view>
        <notifications 
        group="errors"
         position="bottom right"
         />

    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
	 
	methods:{
        ...mapActions("auth", ["getUserData"]),
		
	},
	mounted(){
		if(localStorage.getItem('authToken')){
			this.getUserData();
		}
	}
}
</script>