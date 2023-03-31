<template>
        <div class="accordion-item mt-3">
            <h2 class="accordion-header">
                <button class="accordion-button bg-white" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse' + project._id" aria-expanded="false" :aria-controls="'collapse' + index">
                {{ project.name }}
                </button>
            </h2>
            <div :id="'collapse' + project._id" class="accordion-collapse collapse" :class="{ 'show': project._id === 0 }" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="mb-2">
                        <button class="btn btn-danger btn-sm me-2" @click="deleteProject(project._id)"><i class="fa-solid fa-trash"></i></button>
                        <button class="btn btn-success btn-sm" @click="onUpdate(project)"><i class="fa-solid fa-edit"></i></button>
                    </div>
                    {{project.description}}  
                </div>
                <hr>
                <div class="container d-flex justify-content-evenly p-4">
                    <div class="card alert alert-danger" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                Faire
                                <button class="btn btn-primary btn-sm" @click="addTask()"><i class="fa-solid fa-add"></i></button>
                            </h5>
                        </div>
                        <Tasks :tasks="getTasksByStatus('faire')"  @update-task="updateTask"/>
                    </div>
                    <div class="card alert alert-warning" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                En cours
                            </h5>
                        </div>
                        <Tasks :tasks="getTasksByStatus('en cours')" @update-task="updateTask"/>
                    </div>
                    <div class="card alert alert-success" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                Faite
                            </h5>
                        </div>
                        <Tasks :tasks="getTasksByStatus('faite')" @update-task="updateTask"/>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import Tasks from "./Tasks.vue";
    const urlRoot="http://localhost:8000/api"

    export default {
        name:"Project",
        props:{
            project:Object,
            tasks:Array
        },
        components:{
            Tasks
        },
        methods:{
            getTasksByStatus(status){
                const tasksOfStatus=this.tasks.filter((task)=>task.status==status);
                return tasksOfStatus;
            },
            async deleteProject(id){
                if(confirm("Confirmer La Suppression !")){
                    const res= await fetch(`${urlRoot}/projects/${id}`,{
                        method:"DELETE"
                    })
                    res.status==200?(location.reload()):alert("Error While Deleting In The Server")
                }
            },
            onUpdate(project){
                this.$emit("update-project")
            },
            addTask(){
                this.$emit("add-task")
            },
            updateTask(data){
                this.$emit("update-task", data)
            }
        }
    }
</script>