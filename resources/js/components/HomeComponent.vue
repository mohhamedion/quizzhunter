<style>
.codeBackground {
    background-color: #00000040;
}
.codeText {
    color: #e83e8c;
}
.functionColor {
    color: #61aeee;
}
.rtl {
    direction: rtl;
}

.width100 {
    width: 140px;
}
</style>
<template>
    <div>
        <section id="welcome">
            <div class="container">
                <div id="welcomeContent">
                    <div class="row  text-light">
                        <div class="col-6 ">
                            <!-- <code class="p-3">
						if n<=0:
								print("Incorrect input")
							# First Fibonacci number is 0
							elif n==1:
								return 0
							# Second Fibonacci number is 1
							elif n==2:
								return 1
							else:
								return Fibonacci(n-1)+Fibonacci(n-2)
							
							print(Fibonacci(9)
				</code> -->
                            <pre
                                class="  text-light text-left codeBackground"
                            ><code class="">
	<span class="codeText">def</span> <span class="functionColor">Fibonacci</span>(n):
		<span class="codeText">if</span> n <=0:
		<span class="codeText">elif</span> n==1:
			<span class="codeText">return</span> 0
		<span class="codeText">elif</span> n==2:
			<span class="codeText">return</span> 1
		<span class="codeText">else</span>:
			<span class="codeText">return</span> Fibonacci(n-1)+Fibonacci(n-2)
		print(Fibonacci(9)) 
	</code>
</pre>
                        </div>

                        <div class="col-6 text-right">
                            <h4 class="font175 weight300 ">
                                أدرس البرمجة واختبر نفسك
                            </h4>
                            <h4 class="font11 weight300">
                                افضل طريقة لتجهز نفسك لمقابلة عمل. اختبر نفسك ,
                                وان كنت مؤهلا بما يكفي, انشأ اختبار وكن جزئا من
                                مجتمع المبرمجين العرب وساهم في تطويره
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="line"></div>

        <section class="about">
            <div>
                <h3 class="text-center rtl  pt-5 font175 weight300">
                    ماهو الـ quizzhunter?
                </h3>

                <div class="container">
                    <div class="row">
                          <div class="col-6 text-center rtl">
                            <img
                                class="width100"
                                src="https://www.flaticon.com/premium-icon/icons/svg/3130/3130726.svg"
                                alt=""
                            />
                            <p class="font11 weight300">
                                يعتمد quizzhunter على الزوار انفسهم , اي انك
                                تستطيع انشاء اختبار , مع مراعاة المراقبة وصحة
                                 المعلومات من قبل الادارة
                            </p>
                        </div>

                        <div class="col-6 text-center">
                            <img
                                class="width100"
                                src="/vectors/checklist.png"
                                alt=""
                            />
                            <p class="font11 weight300">
                                هية منصة هادفة الى تطوير المجتمع العربي وتحسينه
                                من الناحية التقنية والمعلوماتية
                            </p>
                        </div>

                 
                    </div>
                </div>
            </div>

            <!-- 	
	<div class="row">
		<div class="col-6 text-center">
			<img class="imgAbout "  src="https://cdn.proghub.ru/home/tests.svg">
 
			 
		</div>		

		<div class="col-6 text-center">
			<img class="imgAbout " src="https://cdn.proghub.ru/home/exercises.svg">
				 
			
		</div>		


 	</div> -->

            <div>
                <h3 class="text-center pt-5 font175 weight300">
                    ابدأ من هنا
                </h3>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="ml-4" v-for="test in bestfive" :key="test.id">
                        <test-card :test="test"  ></test-card>
                    </div>
                   
                </div>
            </div>
        </section>

        <footer-view></footer-view>
    </div>
</template>

<script>
import axios from "axios";
export default {
    mounted() {
        console.log("Component mounted.");
    },
    data() {
        return {
            program: `
	def Fibonacci(n):
		if n<=0:
		elif n==1:
			return 0
		elif n==2:
			return 1
		else:
			return Fibonacci(n-1)+Fibonacci(n-2)
		print(Fibonacci(9)) 
	`,
            typing: "",
            index: 0,
            intervalTyping: null,
            bestfive: []
        };
    },
    methods: {
        encodeWhiteSpaces(str) {
            return str
                .split("")
                .map(function(c) {
                    if (c === " ") return "&nbsp;";
                    else return c;
                })
                .join("");
        },
        async getBestfiveTests() {
            const response = await axios.get(
                "http://localhost:8000/api/tests/bestfive"
            );
            this.bestfive = response.data;
        },
        writeCode() {
            this.intervalTyping = setInterval(() => {
                let word = this.program[this.index++];
                if (this.typing.length == this.program.length) {
                    clearInterval(this.intervalTyping);
                } else {
                    this.typing += word;
                }
            }, 20);
        }
    },
    mounted() {
		//  this.writeCode();
		this.getBestfiveTests();
    }
};
</script>
