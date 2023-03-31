<template>
    <div class="mt-5 container landing">
        <div class="landing-header">
            <h1>Cancan</h1>
            <p>Be More Productive</p>
        </div>
        <div class="landing-text">
            <p>
                Cancan is a sleek and powerful Kanban board web application built
                with Laravel, MongoDB, and VueJs. It's the perfect tool to help 
                you manage your tasks and projects, with a modern and minimalist 
                design that makes it easy to use. Whether you're a busy professional,
                a student, or a freelancer, Cancan can help you stay organized and on
                top of your workload. Try it today and see how it can help you achieve
                your goals!
            </p>
            <button class="btn crud-btn" @click="onClick()">{{ btnText }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        name:"HomeComponent",
        props:{
            btnText:String
        },
        methods:{
            onClick(){
                this.$emit("form-action", {action:"projects/add", payload:null})
            }
        }
    }
</script>
<style>
.landing{
    display: flex;
    flex-direction: row-reverse;
    height: 100vh;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 100px;
}
.landing-header{
    flex-basis: 45%;
    color: #fff;
    font-size: 30px;
}
.landing h1{
    font-size: 130px;
}
.landing-text{
    flex-basis: 50%;
    display: flex;
    flex-direction: column;
}
.landing-text p{
    color: #fff;
    font-size: 20px;
    text-align: justify;
}
.crud-btn{
    width: 160px;
}
</style>