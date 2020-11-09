<style  >
.fail{
    background: repeating-linear-gradient(45deg,#a73a38,#a73a38 175px,#ef5350 0,#ef5350 750px);
}
.passed{
     background:  repeating-linear-gradient(45deg,#47834a ,#47834a 175px,#66bb6a 0,#66bb6a 750px);
}
.font3Weight400{
    font-size: 3em;
    line-height: 100%;
    font-weight: 400;
    color: #4c4c4c;
}
.lightspan{
    font-weight: 400;
    font-size: .9em;
    color: #848484;
}

.correct{
    background:#94cf97;
    color:white;
}
.incorrect{
    background: #f48785;
    color:white;
}

.lineIncorrect{
    background:linear-gradient(45deg,#fff 95%,#f48785 0);
}
.lineCorrect{
    background:linear-gradient(45deg,#fff 95%,#94cf97 0);
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
<template>
    
<div class="container">
    <h3 class="mt-3">
        РЕЗУЛЬТАТ ТЕСТА "{{test.category.category}}: {{test.level}}"
    </h3>
    <div class="mt-4  text-white" :class="resultClass">
            <h2 class="text-center p-5">{{resultText}}</h2>
    </div>

<transition name="fade">

    <div id='rateTest' class="text-center" v-if="showRating">
            <h2>how did you find the test?</h2>
         <span class="fa fa-star h3 pointer " @mouseover="rateHover(rate)" @mouseleave="rateHover(0)" :class=" rate<=rateHoverIndex  ? 'checked' : '' " v-for="rate in 5" v-on:click="rateTest(rate)" :key="rate" ></span>
    </div>
</transition>

    <h3>
        РЕЗУЛЬТАТЫ
    </h3>

    <div class="row">
        <div class="col-4">
            <p class="font3Weight400 text-center">{{points}}</p>
                <p class="text-center lightspan">wining point</p>
        </div>
        <div class="col-4">
            <p class="font3Weight400 text-center">{{percent}}%</p>
                <p class="text-center lightspan">percent</p>
        </div>
                <div class="col-4">
            <p class="font3Weight400 text-center">{{marks}}</p>
                <p class="text-center lightspan">marks</p>
        </div>
    </div>


    <h3 class="mt-4">
        ANSWERS
    </h3>

    <div class="mt-5" v-for="sessionQuestion in questions" :key="sessionQuestion.id">
            <div class="   shadowBox   answer "
            :class="sessionQuestion.mark>=0.5 ? 'lineCorrect' : 'lineIncorrect' "
            >
                   <div class="p-4 font11"><b>#1 {{sessionQuestion.question.question}}</b></div>
            </div>
            <div class="   shadowBox   answer" v-for="answer in sessionQuestion.question.answers" :key="answer.id">
                   <div class="p-4"
                    :class="
                    [sessionQuestion.session_answers.filter((el)=>el.answer_id==answer.id).length>0 && answer.correct ? 'correct' : '',
                    sessionQuestion.session_answers.filter((el)=>el.answer_id==answer.id).length>0 && !answer.correct ? 'incorrect' :''
                    ]"  
                     >{{answer.answer}}</div>
            </div>
        

    </div>

</div>

</template>

<script>
import axios from 'axios'
export default {
    data(){
        return {
            test:{},
            session:{},
            questions:[],
            resultClass:null,
            resultText:null,
            marks:0,
            percent:0,
            points:15,
            showRating:false,
            rateHoverIndex:0

        }
    }
,
    methods:{
      async  getResult(){
           const response = await axios.get('http://localhost:8000/api/result/'+this.$route.params.session_id);
           console.log(response);
            this.test =   response.data.test;
            this.session = response.data.session;
            this.questions = response.data.session_questions;
            this.showRating = response.data.showRate;
            await  this.countPoints();
            this.giveTheResult();

        },
        countPoints(){
            this.marks =this.questions.map(el=>el.mark).reduce((x,y)=>{return x+y}) || 0;
            this.percent = (this.marks * 100)/this.questions.length;
        },
        giveTheResult(){
            if(this.percent<50){
                this.resultClass = "fail";
                this.resultText="YOU DID NOT PASS :(";
            }else{
                this.resultClass = "passed";
                this.resultText="you pass :)";

            }
        },
        rateHover(rate){
            this.rateHoverIndex = rate;
            
            },
       async rateTest(rate){
           this.showRating = !this.showRating;
          const response =  await  axios.post('http://localhost:8000/api/rate',{
                test_id:this.test.id,
                rate:rate
            });

            console.log(response)

        }
        
    },

    created(){
        this.getResult();
    }


}
</script>