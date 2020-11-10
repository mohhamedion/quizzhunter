<style >
.codeTextArea{
    background-color: #2b3137;
    color:white;
}


</style>

<template>
    <div class="container mt-2 ">
        <h2 class="lightfont text-right">الأختبار </h2>
        <div class="bg-white  form-inline p-3 shadowBox mb-2">
            <li class="col-4">{{test.category.category}}</li>
            <li class="col-2">{{test.level.level}}</li>
            <li class="col-4">{{test.created_at}}</li>
            <li class="col-2">{{test.second_per_question}}s</li>
        </div>

        <div id="add" class="shadowBox p-3 text-right rtl">
            <h2 class="lightfont">أضف  سؤالا</h2>
            <div class="form-group">
                <textarea
                    name=""
                    id=""
                    cols="30"
                    rows="3"
                    class="form-control "
                    placeholder="مثال: ماهو الوسم الخاص بجسم الصفحة في html"
                    v-model="form.question"
                 ></textarea>
                
            </div>

            <div class="form-group">
                <textarea
                    name=""
                    id=""
                    cols="30"
                    rows="3"
                    class="form-control codeTextArea"
                    placeholder="//هنا تستطيع كتابة كود , يمكنك تركه فارغا"
                    v-model="form.code"
                >
</textarea
                >
                
            </div>

            <h3 class="lightfont">الأجوبة</h3>

            <div class="form-group  ">
                <input
                    type="text"
                    class="form-control"
                    v-model="dataHandler.answer"
                 />
                 
                <div class="text-right pt-2">
                    <button class="btn btn-danger" v-on:click="addAnswer">
                        اضف جواب
                    </button>
                </div>
            </div>

            <div
                class="bg-white p-3 shadowBox mb-2 "
                v-for="answer in form.answers"
                :key="answer.id"

            >
                <div class="row">
                    <li class="col-8">{{ answer.answer }}</li>

                    <li class="col-4 text-left">
                            الأجابة الصحيحة؟
                            <input
                            type="checkbox"
                            class="mr-2"
                            v-model="answer.correct"
                        />
                        <span
                            class="badge badge-danger pointer "
                            v-on:click="removeAnswer(answer)"
                            >X</span
                        >
                    </li>
                </div>
            </div>

            <div class="text-left">
                <button class="btn btn-success" v-on:click="createQuestion">
                    أنشاء سؤال
                </button>
            </div>
        </div>

        <div id="createdQuestions" class="">
            <div class="mt-3" v-for="(question,index) in questions" :key="question.id">
                <div class="   shadowBox   answer">
                    <div class="p-4 font11">
                        <b>#{{index+1}} {{ question.question }}</b>
                        <div class="float-right">
                        <b ><span class="btn btn-danger" v-on:click="deleteQuestion(question.id,index)">X</span></b>

                        </div>
                    </div>
               
                </div>
                <div>
                      <div class="code " v-if="question.code">
                    <p class="text-white p-3">
                        {{question.code}}
                    </p>
                 </div>
                </div>
                <div
                    class="   shadowBox answer db-light "
                    v-for="answer in question.answers"
                    :key="answer.id"
                    :class="answer.correct ? 'correct' : 'incorrect'"
                >
                    <div class="p-4 ">{{ answer.answer }}</div>
                </div>
            </div>
        </div>

        <hr />

        <div>
            <div class="form-group">
                <div class="text-left pt-2">
                    <button class="btn btn-success" v-on:click="publishTest">أطلق الاختبار</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["test_id"],

    data() {
        return {
            form: {
                question: null,
                code: null,
                answers: []
            },
            dataHandler: {
                answer: null
            },
            questions: [],
            test:{
                category:{category:null},
                level:null
            },
         
        };
    },
    methods: {
   
        handleError(error){
            let errors = Object.values(error);
            console.log(errors)
            let DomError = "";
                for((error) in errors){
                    DomError+="<li>"+errors[error]+"</li>";
                }


             this.$notify({
                    group: 'errors',
                    title: 'خطأ',
                    text: DomError,
                    type: 'error',
                    position:"bottom right"

                });
        },

        createQuestion() {
           
            axios
                .post("http://localhost:8000/api/questions", {
                    question: this.form.question,
                    code: this.form.code,
                    answers: this.form.answers,
                    test_id: this.$route.params.test_id
                })
                .then(response => {
                    if(response.data.error){
                            this.handleError(response.data.error);
                    }else{
                        this.addQuestion(response.data[0])
                        this.clearFormData();

                    }
                });

               
        },
        clearFormData() {
            this.form = {
                question: null,
                code: null,
                answers: []
            };
        },
        addAnswer() {
            if (!this.dataHandler.answer) {
                return false;
            }
            this.form.answers.push({
                answer: this.dataHandler.answer,
                correct: false,
                id: this.form.answers.length
            });
            this.dataHandler.answer = null;
            this.dataHandler.correct = false;
        },
        addQuestion(question){
            this.questions.unshift(question);
        },
        removeAnswer(answer) {
            let index = this.form.answers.indexOf(answer);
            this.form.answers.splice(index, 1);
        },
        deleteQuestion(question_id,index) {
            axios.delete("http://localhost:8000/api/questions/delete/"+question_id).then(response => {
                console.log(response.data)
                if(response.status==200){
                    this.questions.splice(index,1);
                }
            });
        },
        getTest(){
            axios.get('http://localhost:8000/api/tests/getDraftTestsById/'+this.$route.params.test_id).then(response=>{
                console.log(response.data)
                this.test = response.data[0];
                this.questions = this.test.questions;
                

            })
        },
        publishTest(){
             axios.patch('http://localhost:8000/api/tests/publish/'+this.$route.params.test_id).then(response=>{
                if(response.status==200){
                    this.$router.push({ name: "home" });
                }
              
            })
        }
    },
    mounted() {
         this.getTest();
    
    }
};
</script>
