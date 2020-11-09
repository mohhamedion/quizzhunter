import VueRouter from "vue-router";
import HomeComponent from '../components/HomeComponent.vue';

import TestsComponents from '../components/TestsComponents.vue';
import TestPage from '../components/test/TestPage.vue';
import TestSession from '../components/test/TestSession.vue';
import ResultPage from '../components/result/resultPage.vue';
import AddTest from '../components/test/AddTest.vue';
import AddQuestion from '../components/questions/AddQuestion.vue';
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import Profile from '../components/user/Profile.vue';
import testResults from '../components/user/testResults/testResults.vue';
import createdTests from '../components/user/createdTests/createdTests.vue';
 
const guest = (to, from, next) => {
    if (!localStorage.getItem("authToken")) {
      return next();
    } else {
      return next("/");
    }
  };
  const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
      return next();
    } else {
      return next("/login");
    }
  };


  
const routes = [
    {
        name: 'home',
        path: '/',
        component: HomeComponent
    },
    {
      name: 'tests',
      path: '/tests',
      component: TestsComponents
    },
    {
      name: 'test',
      path: '/test/:test_id',
      component: TestPage
    },
    {
      name: 'session',
      path: '/session',
      beforeEnter:auth,
      component: TestSession
    },
    {
      name: 'result',
      path: '/result/:session_id',
      component: ResultPage
    },
    {
      name: 'addTest',
      path: '/add/test',
      beforeEnter:auth,
      component: AddTest
    },
    {
      name: 'addQuestion',
      path: '/add/question/:test_id',
      beforeEnter:auth,

      component: AddQuestion
    },
    {
      name: 'login',
      path: '/login',
      beforeEnter:guest,
      component: Login
    },
    {
      name: 'register',
      path: '/register',
      beforeEnter:guest,
      component: Register
    },
    {
      name: 'profile',
      path: '/profile/:user_id/',
      redirect: '/profile/:user_id/',
      component: Profile,
       children:[
        {
          name:'createdTests',
          path:'',
          component:createdTests
        } 
        ,

         {
           name:'profileTestResult',
           path:'testResults',
           component:testResults,
           
         },
     
       ]
    },
    ];

    const router = new VueRouter({ mode: 'history', routes: routes});
    export default router;