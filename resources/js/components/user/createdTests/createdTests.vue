<template>
 <div>

             <div class="col-12  ">
                <div class="row">
                         <div v-for="test in tests" class="ml-5" :key="test.id">
                                 <test-card :test="test"  ></test-card>    
                         </div>
                </div>
            </div>

 </div>
</template>

<script>
 
export default {
    props:['tests'],
    data(){
        return {
            ProfileTests:[]
        }
    } 
    
 
}
</script>