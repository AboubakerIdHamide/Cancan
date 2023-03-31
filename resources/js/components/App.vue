<template>
    <div>
        <FormComponent
            :formAction="formAction"
            @form-data="handleSubmit"
            :showForm="showForm"
        />

        <HomeComponent
            @form-action="formActionMethod"
            :btnText="btnText"
        />

        <ProjectsComponent 
            @update-project="formActionMethod"
            @add-task="formActionMethod"
            @update-task="formActionMethod"
        />
    </div>
</template>

<script>
import ProjectsComponent from './Projects.vue';
import FormComponent from './Form.vue';
import HomeComponent from './Home.vue';
const urlRoot="http://localhost:8000/api"

export default {
    name:"App",
    data(){
        return{
            formAction:{action:"", payload:""},
            showForm:false,
            btnText:"Ajouter Projet"
        }
    },
    components:{
        ProjectsComponent,
        FormComponent,
        HomeComponent
    },
    methods:{
        formActionMethod(params){
            this.toggleShowForm();
            this.btnText=this.showForm?"Annuler":"Ajouter Projet";
            this.formAction=params;
        },
        async updateDb(route, method, payload){
            const reqUrl=method=='PUT'?`${urlRoot}/${route}/${payload._id}`:`${urlRoot}/${route}`;
            const res= await fetch(reqUrl,
            {
                method,
                headers:{"Content-Type":"application/json"},
                body:JSON.stringify(payload)
            })
            if(res.status==422){
                let errors=await res.json();
                    errors=errors.errors;
                let errorsTexts=Object.values(errors);
                let errorText="";
                errorsTexts.map((error)=>{
                    errorText+=`${error[0]}\n`
                })
                alert(errorText)
            }else{
                alert("Success");
                location.reload();
            }
        },
        async handleSubmit(params){
            const res= await this.updateDb(params.route, params.method, params.payload);
        },
        toggleShowForm(){
            this.showForm=!this.showForm;
        }
    }
}
</script>