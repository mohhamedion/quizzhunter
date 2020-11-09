<style>
.testCard .image {
    box-shadow: 0 1px 0 0 rgba(232, 233, 235, 0.5);
}

.testCard {
    width: 201px;

    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.12), 0 1px 1px rgba(0, 0, 0, 0.24);
}

.img {
    height: 122px;
    width: 200px;
    object-fit: cover;
}

.checked {
    color: orange;
}
.font10px{
    font-size:10px
}

 

 .joinerBadge{
     background-color:#007aff;
     color:white
 }
 .middleBadge{
     background-color: #f0db4f;
     color:black
 }
 
.seniorBadge{
    background: #339;
    background: -webkit-linear-gradient(90deg,#339,#f0c);
    background: linear-gradient(90deg,#339,#f0c);
    color:white
}
</style>

<template>

    <div class="testCard">
        <div class=" mb-5 border">
            <router-link :to="{ name: 'test', params: { test_id: test.id } }">
            <div class="image">
                <img v-bind:src="test.category.image" class="img" />
            </div></router-link>

            <div class="p-2">
                
                <h3 class="font11">
                    <router-link
                        :to="{ name: 'test', params: { test_id: test.id } }"
                        >{{ test.category.category }}</router-link
                    >                <span v-if="test.published==0" class="badge badge-danger text-light">DRAFT</span>

                </h3>
                
            <div class="">

                <span class="badge ranbow_badge text-light">{{
                    test.category.category
                }}</span>
                <span class="badge  " :class="[test.level.id==1 ? 'joinerBadge' : '',test.level.id==2 ? 'middleBadge' :'' ,test.level.id==3 ? 'seniorBadge' :'' ] ">{{
                    test.level.level
                }}</span>
            </div>

                <div class="form-inline">
                    
                    <div v-for="rate in 5">
                        <div v-if="rate <= test.totalRate">
                            <span class="fa fa-star checked"></span>
                        </div>
                        <div v-else>
                            <span class="fa fa-star "></span>
                        </div>
                    </div>

                      <span class="font10px float-right"> <router-link :to="{params:{user_id:test.user.id},name:'profile'}">{{test.user.firstname+test.user.lastname}}</router-link> </span>  
                  
                </div>
                     

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["test"]
};
</script>
