<style>
.blackBackground {
    background-color: #2b3137;
    height: 300px;
    background: url(https://cdn.proghub.ru/home/background.svg), #2b3137;
}

.font400 {
    font-weight: 400;
}

li {
    list-style-type: none;
}

.lightfont {
    font-weight: lighter;
}

.cardImage {
    text-align: center;
    padding: 0.5em;
    border-bottom: 1px solid rgb(204, 192, 192);
}

.grayBackground {
    background-color: #f7f8fa;
    min-height: 400px;
}

#testInfo {
    margin-top: -200px;
    width: 400px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    max-height: 500px;
}

.testBtn {
    background-color: #4d96e4;
    color: white;
}

.shadowBox {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

.profilePic {
    width: 30px;
    border-radius: 4px;
}

.border1px {
    border: 1px solid rgb(204, 192, 192);
}
</style>

<template>
    <div>
        <div class="blackBackground">
            <div class="container">
                <div class=" ">
                    <div class="col-6 pt-5">
                        <h1 class="text-light font400">
                            {{ test.category.category }}
                        </h1>
                            <span class="badge ranbow_badge text-white ">{{test.level.level}}</span>

                    </div>
                </div>
            </div>
        </div>

        <div class="grayBackground ">
            <div class="container">
                <div class="row">
                    <div class="col-8">
                        <div class="p-4">
                            <p class="text-right">{{ test.description }}</p>
                        </div>

                        <div id="bestInMonth">
                            <h1   class="font175 weight300 text-right" v-if='bestIn30Days.length>0'>الافضل اخر 30 يوما</h1>
                            <div
                                class="bg-white  form-inline p-3 shadowBox mb-2"
                                v-for="(session,index) in bestIn30Days"
                                :key="session.id"
                            >
                                <li class="col-2">{{medals[index]}}</li>
                                <li class="col-4">{{session.user.firstname+session.user.lastname}}</li>
                                <li class="col-2">{{session.totalPoints}}/{{session.session_questions_count}}</li>
                                <li class="col-2">{{session.inTime}}s</li>
                                <li class="col-2">10xp</li>
                            </div>
 
                           
                        </div>

                        <div id="lastSessions " class="">
                            <div class="rtl">
                                <h1 v-if="lastSessions.length>0" class="font175 weight300 text-right ">اخر المختبرين</h1>
                            </div>
                            <div
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
                            </div>
 
                        </div>
                    </div>

                    <div id="testInfo" class="float-right col-4 ">
                        <div class="cardImage pl-3 pr-3">
                            <img
                                :src="test.category.image"
                                alt=""
                                class="img"
                            />
                        </div>
                        <div class="p-3 rtl">
                            <li class="lightfont">
                             {{test.category.category}}    <span class="float-right ">الفئة:</span>
                            </li>
                              <li class="lightfont">
                            {{test.level.level}}    <span class="float-right"> الصعوبة:</span>
                            </li>
                            <li class="lightfont">
                             {{test.questions_count}} <span class="float-right">عدد الاسألة:</span>
                            </li>
                            <li class="lightfont">
                             {{test.questions_count*test.second_per_question || 0}} ث <span class="float-right"> الوقت المحدد:</span>
                            </li>
                            <li class="lightfont">
                                 <router-link :to="{params:{user_id:test.user.id},name:'profile'}">{{test.user.firstname+test.user.lastname}}</router-link> <span class="float-right">الكاتب:</span>
                            </li>
                             
                        </div>
                        <div class="pl-1 pr-1 pb-2 ">
                            <button class="btn testBtn form-control   mb-1" v-on:click="createTestSession">
                                <p class="text-light">اختبر الان</p> 
                            </button>
                            <!-- <button class="btn btn-success form-control mb-1">
                                Example
                            </button> -->
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <h2 class="font175 weight300">التقييمات</h2>
                    <div class="col-8 border1px  pb-4 pl-3 pr-3 pt-2">
                        <textarea
                            name=""
                            id=""
                            cols="30"
                            class="form-control "
                            rows="5"
                            v-model="inputComment"
                        ></textarea>
                        <div class="text-right">
                            <button class="btn " v-on:click="createComment">علق</button>
                        </div>
                    </div>

                    <div id="comments" class="mt-3 mb-2" v-for="comment in comments" :key="comment.id">
                        <div class="bg-white shadowBox col-8">
                            <p class="pt-2">
                                <img
                                    src="https://cdn.proghub.ru/avatars/cd728b24a9bb103b95644c04fd1e4a3c.png"
                                    class="profilePic"
                                    alt=""
                                />
                                <b>{{comment.user.firstname}} {{comment.user.lastname}}</b>
                            </p>
                            <div class="pb-2">{{comment.comment}}</div>
                        </div>
                    </div>
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
            test: {
                category: { category: null,image:null},
                description:null,
                level:{}

            },
            comments:[],
            inputComment:null,
            medals : ['🥇','🥈','🥉'],
            bestIn30Days : [],
            lastSessions:[]
        };
    },

    methods: {
        getTestInfo() {
            axios
                .get("http://localhost:8000/api/tests/" + this.$route.params.test_id)
                .then(response => {
                    console.log(response.data)
                    this.test = response.data[0];
                    this.comments = this.test.comments;
                    this.bestIn30Days = response.data.bestIn30Days;
                    this.lastSessions = response.data.lastSessions;
               
                   

                });
        },
        createTestSession(){
            axios.post('http://localhost:8000/api/testSessions',{test_id:this.$route.params.test_id}).then(response=>{
                console.log(response)
                if(response.status==200){
                    this.$router.push({'name':'session'})
                }
            })
        },
        createComment(){
            axios.post('http://localhost:8000/api/comments',{test_id:this.$route.params.test_id,comment:this.inputComment}).then(response=>{
                console.log(response)
                if(response.status==200){
                    this.unshiftComment(response.data)
                   }
            })
        },

        unshiftComment(comment){
            this.comments.unshift(comment);
        }
    },

    mounted() {
        this.getTestInfo();
    }
};
</script>
