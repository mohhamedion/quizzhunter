<style>
/* 
.grayBackgroundSession{
 } */

body {
    background-color: #f7f8fa;
}

.pointer {
    cursor: pointer;
}

.code {
    background-color: #2b3137;
}
</style>
<template>
    <div class="grayBackgroundSession">
        <div class="container pt-3">
            <div class="row">
                <div class="col-6">
                    <h2 class="font175">
                        {{ session.test.category.category }}
                    </h2>
                </div>
                <div class="col-6">
                    <h2 class="font175 text-right">{{ timeString }}</h2>
                </div>
            </div>
            <hr />

            <!-- <div id="question">
           <p class="lightfont">question 1/10</p>
           <p class="font175">How to do console.log in js?</p>

           <div id='answers'>
               <div class="bg-white  shadowBox pointer answer" v-on:click='chooseAnswer'>
                   <p class="p-4">How do you ????</p>
               </div>

                   <div class="bg-white  shadowBox pointer answer" v-on:click='chooseAnswer'>
                   <p class="p-4">How do you ????</p>
               </div>
                   <div class="bg-white  shadowBox pointer answer" v-on:click='chooseAnswer'>
                   <p class="p-4">How do you ????</p>
               </div>
           </div>

           <div class="text-right">
            <button class="btn btn-success">Answer</button>

           </div>
       </div> -->

            <div id="question">
                <p class="lightfont">question 1/10</p>
               <p class="font175">{{sessionQuestions[currentQuestion].question.question}}</p>

                <div class="code" v-if="sessionQuestions[currentQuestion].question.code">
                    <p class="text-white p-3">
                        {{sessionQuestions[currentQuestion].question.code}}
                    </p>
                </div>

                <div id="answers">
                    <div
                        v-for="answer in sessionQuestions[currentQuestion].question.answers"
                        class="bg-white  shadowBox pointer answer"
                        v-on:click="(e)=>chooseAnswer(e,answer.id)"
                        :key="answer.id"
                    >
                        <p class="p-4">{{answer.answer}}</p>
                    </div>

                    
                </div>

                <div class="text-right">
                    <button class="btn btn-success" v-on:click="answerQuestion">Answer</button>
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
            session: {},
            timeInteger: 0,
            timeString: "00:00:00",
            sessionQuestions:[],
            currentQuestion:0,
            choosenAnswers:[],
            interval:null
        };
    },

    methods: {
        chooseAnswer(e,answerId) {
            if (e.target.classList.contains("bg-primary")) {
                e.target.classList.remove("bg-primary");
                let index = this.choosenAnswers.indexOf(answerId);
                this.choosenAnswers.splice(index,1);
            } else {
                this.choosenAnswers.push(answerId);

                e.target.classList.add("bg-primary");
            }
        },
        getTestSession() {
            axios
                .get("http://localhost:8000/api/testSessions")
                .then(response => {
                    if (response.status == 200) {
                        console.log(response);
                        this.session = response.data.session;
                        this.timeInteger = response.data.timeInteger;
                        this.timeString = response.data.timeString;
                        this.sessionQuestions = response.data.session.session_questions.filter((el)=>{
                            return !el.answered
                            });
                            if(this.sessionQuestions.length==0){
                              this.$router.push({path:"/result/"+this.session.id});
                            }
                        this.setTimer();


                    }
                })
                .catch(err => {
                    console.log(err);
                    this.$router.push({ name: "tests" });
                });
        },
        setTimer() {
           this.interval = setInterval(() => {
           console.log(this.$router.currentRoute.name);

                this.timeInteger = this.timeInteger - 1;
                    if (this.timeInteger < 0) {
                    this.finishSessionLocaly();

                     }
                this.timeString = new Date(this.timeInteger * 1000)
                    .toISOString()
                    .substr(11, 8);
            }, 1000);
        } ,

      async   answerQuestion(){
            let question  = this.sessionQuestions[this.currentQuestion].id;
            let response = await axios.post('http://localhost:8000/api/testSessions/answerQuestion',{
                session_question_id:question,
                answer_ids: this.choosenAnswers
            });
                    

                if(response.status==200){
                    this.moveToNextQuestionOrRedirect();
                }

        },
        moveToNextQuestionOrRedirect(){
            this.choosenAnswers = [];
            this.currentQuestion++;
            if(!this.sessionQuestions[this.currentQuestion]){
                    this.finishSessionLocaly();
            }else{
                    console.log('IS EXIST')

            }
        },
        finishSessionLocaly(){
           
                            
            clearInterval(this.interval);
            if(this.$router.currentRoute.name=="session"){
                console.log(this.$router.currentRoute)
                this.$router.push({path:"/result/"+this.session.id});
            }

        }
    
    },
    mounted() {
        this.getTestSession();
    }
};
</script>
