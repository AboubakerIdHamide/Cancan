<template>
    <form @submit="onSubmit" :class="{'d-flex crud-from':true, 'hide':!showForm}" method="post">
        <input type="text" v-model="name" name="name" :placeholder="defaultName"/>
        <input type="text" v-model="description" name="description" :placeholder="defaultDescription"/>
        <div v-if="formAction.action === 'tasks/add' || formAction.action === 'tasks/update'">
            <input type="date" v-model="date_debut" name="date_debut" :placeholder="defaultDate_debut"/>
            <input type="date" v-model="date_fin" name="date_fin" :placeholder="defaultDate_fin"/>
            <select v-model="status" :placeholder="defaultStatus">
                <option value="faire">Faire</option>
                <option value="en cours">En Cours</option>
                <option value="faite">Faite</option>
            </select>
        </div>
        <input type="submit" :value="buttonText" class="btn btn-block text-upper crud-btn" />
    </form>
</template>

<script>
    export default {
        name:"FormComponent",
        data(){
            return{
                name:"",
                description:"",
                status:"",
                date_debut:"",
                date_fin:"",
                project_id:"",
                buttonText:"Ajouter Projet",
                method:"",
                route:"",
                defaultName:"Nom",
                defaultDescription:"Description",
                defaultStatus:"",
                defaultDate_debut:"",
                defaultDate_fin:""
            }
        },
        props:{
            formAction:Object,
            showForm:Boolean
        },
        updated(){
            const names=this.formAction.action.split("/");
            this.buttonText=`${names[1]=="update"?"Modifier":"Ajouter"} ${names[0]=="projects"?"Projet":"Tâche"}`;
            this.route=names[0];
            this.method=names[1]=="add"?"POST":"PUT";
            if(this.formAction.payload!=null){
                this.defaultName=this.formAction.payload?.name;
                this.defaultDescription=this.formAction.payload?.description;
                if(names[0]=="tasks"){
                    this.defaultStatus=this.formAction.payload?.status;
                    this.defaultDate_debut=this.formAction.payload?.date_debut;
                    this.defaultDate_fin=this.formAction.payload?.date_fin;
                }
            }
        },
        mounted(){
            console.log(this.showForm);
        },
        methods:{
            onSubmit(e){
                e.preventDefault();
                this.$emit("form-data", {
                    method:this.method,
                    route:this.route,
                    payload:{
                        _id:this.formAction.payload?._id || undefined,
                        name:this.name,
                        description:this.description,
                        status:this.status,
                        date_debut:this.date_debut,
                        date_fin:this.date_fin,
                        project_id:this.formAction.payload?.project_id,
                    }
                })
            }
        }
    }
</script>
<style>
    body{
        width: 100%;
        min-height: 100vh;
        background:linear-gradient(45deg, #FF7800, #FFA45B, #FFDA77);
    }
    .crud-from{
        position: fixed;
        right: 0;
        top: 0;
        width: 30%;
        background-color: #fff;
        border-left: 2px solid #FF7800;
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 20px;
        padding-top: 30px;
        z-index: 100;
        transition: 0.3s;
    }
    .crud-from input, select{
        width: 100%;
        border: none;
        outline: none;
        height: 40px;
        border: 1px solid #FF7800;
        color: #FF7800;
        background-color: transparent;
        margin-bottom: 20px;
        text-indent: 15px;
    }
    .crud-from select option{
        color:black !important;
    }
    .hide{
        transform: translateX(150%);
    }
</style>