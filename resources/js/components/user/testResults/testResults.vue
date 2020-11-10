
<style  >
.date{
    color:#848484
}
</style>
<template>
    <div>
                      <h1 class="font175 weight300">نشاطاته الاخيرة</h1>
                                 <div id="lastSessions">
                                     
                             <div  class="bg-white   shadowBox mb-2"  v-for="session in sessions" :key="session.id"> 
                                 <div class="pt-2 pl-2">
                                  <span class="float-left pr-2 date">{{ session.created_at.substr(0,session.created_at.indexOf('T')) }}</span>

                                     <div class="text-right rtl mr-1">
                                     <span v-if="session.totalPoints/session.session_questions_count>=0.5"><span class="badge badge-success  ">✓</span>انجز اختبار {{session.test.category.category}}</span>
                                     <span v-else><span class="badge badge-danger mr-1">X</span>فشل في انجاز الاختبار </span> 
                                     </div>
                  
                                 </div>  
                                <div class="p-2   text-right">
                                    <!-- has been testing  PHP: Junior with result of 10/20 -->
                                    
                                   وفشل في انجاز الاختبار بنتيجة {{session.totalPoints}}/{{session.session_questions_count}} <router-link :to="{name:'test', params:{test_id:session.test_id}}">{{session.test.category.category}}</router-link>  قد اختبر 
                                   
                                </div>
                             </div>     
                          </div>

                                 <!-- <div
                                class="bg-white  form-inline p-3 shadowBox mb-2"
                                v-for="session in lastSessions"
                                :key="session.id"
                              >
                                <li class="col-4">{{session.user.firstname+session.user.lastname}}</li>
                                <li class="col-3">{{session.totalPoints}}/{{session.session_questions_count}}</li>
                                <li class="col-3">{{ session.created_at.substr(0,session.created_at.indexOf('T')) }}</li>
                                <li class="col-2">
                                    <span class="badge-success badge" v-if="session.totalPoints/session.session_questions_count>=0.5">✓</span>
                                    <span class="badge-danger badge"  v-else>X</span>
                                </li>
                            </div> -->
    </div>
</template>
<script>
export default {
    props:['sessions']
}
</script>