<template>
    <div  :key="project._id" v-for="project in projects"  class="accordion mb-5" id="accordionExample">
        <Project 
            :project="project"
            :tasks="projectTasks(project._id)"
            @update-project="$emit('update-project', {action:'projects/update', payload:project})"
            @add-task="$emit('add-task', {action:'tasks/add', payload:{project_id:project._id}})"
            @update-task="updateTask"
        />
    </div>
</template>

<script>
    import Project from "./Project.vue"
    const urlRoot="http://localhost:8000/api"
    export default {
        name:"ProjectsComponent",
        components:{
            Project,
        },
        data(){
            return {
                projects:[],
                tasks:[],
            }
        },
        methods:{
            async fetchAll(route){
                const res= await fetch(`${urlRoot}/${route}`)
                const data= await res.json();
                return data;
            },
            projectTasks(prjId){
                const tasksofTheProject=this.tasks.filter((task)=>task.project_id==prjId);
                return tasksofTheProject;
            },
            updateTask(data){
                this.$emit("update-task", data)
            }
        },
        async created(){
            const projectsRes=await this.fetchAll('projects');
            const tasksRes=await  this.fetchAll('tasks');
            this.projects=projectsRes.projects;
            this.tasks=tasksRes.tasks;
        }
    }
</script>