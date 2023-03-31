<template>
    <div  :key="task._id" v-for="task in tasks"  class="col bg-white rounded p-2 card border-light mb-1">
            <div class="card-header d-flex justify-content-between align-items-center">
                {{task.name}}
                <div>
                    <button class="btn btn-danger btn-sm me-2" @click="deleteTask(task._id)"><i class="fa-solid fa-trash"></i></button>
                    <button class="btn btn-success btn-sm"><i class="fa-solid fa-edit" @click="updateTask(task)"></i></button>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{task.description}}</p>
                <hr>
                <div class="text-center text-primary">
                    {{task.date_debut}} - {{task.date_fin}}
                </div>
            </div>
    </div>
</template>

<script>
    const urlRoot="http://localhost:8000/api"
    export default {
        name:"Tasks",
        data(){
            return{
                tasks:[]
            }
        },
        props:{
            tasks:Array
        },
        methods:{
            async deleteTask(id){
                if(confirm("Confirmer La Suppression !")){
                    const res= await fetch(`${urlRoot}/tasks/${id}`,{
                        method:"DELETE"
                    })
                    res.status==200?(location.reload()):alert("Error While Deleting In The Server")
                }
            },
            updateTask(task){
                this.$emit("update-task", {action:'tasks/update', payload:task})
            }
        }
    }
</script>