<template>
  <div class="body-right-container">
      <h1>Development CRM</h1>

      <div class="horizontal">
          <img :src="require('../../images/horizontal.png').default" alt="horizontal image" />
      </div>

      <p>
          This is a local CRM development project. This project is built to test Laravel & Vue Operations.
          This project is used purely with Vue & Laravel controller.
          The project will be upgraded in the future with a lot of fancy features.
      </p>
      <div class="tasks">
        <div class="today-tasks">
          <div class="add-tasks">
              <h2 id="crmlaravel-today-tasks">Today Tasks</h2>

              <div class="add-action">
                  <img :src="require('../../images/add.png').default" atl="Add ">
              </div>

              <form action="" @submit="addTodayTask">
                <input type="text" v-model="newTodayTask"/>
              </form>
          </div><!-- add-tasks -->
          <ul id="crmlaravel-today-tasks-list" class="tasks-list">
                <li v-for="todayTask in todayTasks" v-bind:key="todayTask.taskId" >
                    <div class="info">
                        <div class="left">
                            <label class="myCheckBox">
                                <input type="checkbox" name="test"
                                    :checked="todayTask.completed"
                                    @change="updateCompletionTodayTask(todayTask.taskId)"/>
                            <span></span>
                            </label>

                            <h4 :id="todayTask.taskId" contentEditable="false">
                                {{todayTask.title}}
                            </h4>
                        </div><!-- left -->

                        <div class="right">
                            <img :src="require('../../images/edit.png').default" alt="Edit Task"
                            @click="toggleEditTitleTodayTask(todayTask.taskId)">
                            <img :src="require('../../images/del.png').default" alt="Delete Task"
                            @click="deleteTodayTask(todayTask.taskId)">
                        </div><!--right-->
                    </div><!-- info -->

                </li>
              </ul>
          </div><!-- today-tasks -->

          <div class="upcoming-tasks">
              <div class="add-tasks">
                  <h2 id="crmlaravel-upcoming-tasks">Upcoming Tasks</h2>

                  <div class="add-action">
                    <img :src="require('../../images/add.png').default" atl="Add ">
                  </div>

                  <form action="" @submit="addUpcomingTask($event)">
                      <input type="text" v-model="newUpcomingTask"/>
                  </form>
              </div><!-- add-tasks -->

              <ul id="crmlaravel-upcoming-tasks-list" class="tasks-list">
                <li v-for="upcomingTask in upcomingTasks" v-bind:key="upcomingTask.taskId" >
                    <div class="info">
                        <div class="left">
                            <label class="myCheckBox">
                                <input type="checkbox" name="test"
                                    :checked="upcomingTask.completed"
                                    @change="checkUpcomingTask(upcomingTask.taskId)"/>
                            <span></span>
                            </label>

                            <h4 :id="upcomingTask.taskId" contentEditable="false">                           
                                {{upcomingTask.title}}
                            </h4>
                        </div><!-- left -->

                        <div class="right">
                            <img :src="require('../../images/edit.png').default" alt="Edit Task"
                            @click="toggleEditTitleUpcomingTask(upcomingTask.taskId)">
                            <img :src="require('../../images/del.png').default" alt="Delete Task"
                            @click="deleteUpcomingTask(upcomingTask.taskId)">
                        </div><!--right-->
                    </div><!-- info -->
                </li>
            </ul>
          </div><!-- upcoming -->

      </div><!-- task -->
  </div>
</template>

<script>
import AppVue from './App.vue';
const {zeroPadding, getRandomString} = require('./Helper.js').default;
// let zeroPad = require('./Helper.js');
// let getRandomString = require('./Helper.js');

export default {
    data(){
        return {
            todayTasks: [],
            upcomingTasks: [],
            newUpcomingTask:"",
            newTodayTask:"",
        };
    },
    created(){
        this.fetchTodayTasks();
        this.fetchUpcomingTasks();           
    },
    methods:{
        //** I. Upcoming task **//
        // Get all upcoming tasks
        fetchUpcomingTasks(){
            fetch('/api/upcoming')
            .then(response => response.json())
            .then(({data}) => {
                this.upcomingTasks = data;
                //console.log(data);
                })
            .catch(error => console.log(error));
        },
        async addUpcomingTask(e){
            e.preventDefault();

            let totalTasks = this.upcomingTasks.length;            

            let newTaskID = `TASKID-${zeroPadding(totalTasks + 1,3)}-${getRandomString(10)}`;
            //let newTaskID = 'TASK-ID-003-ETGfXelSBP'; // test on existing item
            // check newTaskID existed
            let queryTaskId = await fetch(`/api/upcoming/searchbyid?taskId=${newTaskID}`,{
                    method: 'GET',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                })
                .then(response => response.json())            
                .catch(error => console.log(error));            
            
            // if empty array & length = 0, proceed adding new item
            
            let queryResult = Array.isArray(queryTaskId.data[0]) ? queryTaskId.data[0] : Array(queryTaskId.data[0]);
           
            // if has object existed with same ID, generate another ID
            while(queryResult.length > 0){
                console.log('New task ID detected. Generate another task Id');
                newTaskID = `TASKID-${zeroPadding(totalTasks + 1,3)}-${getRandomString(10)}`;

                queryTaskId = await fetch(`/api/upcoming/searchbyid?taskId=${newTaskID}`,{
                    method: 'GET',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                })
                .then(response => response.json())            
                .catch(error => console.log(error));

                queryResult = Array.isArray(queryTaskId.data[0]) ? queryTaskId.data[0] : Array.from(queryTaskId.data[0]);
            } 
          
            // Task ID: TASKID-003-<random_string>
            if(totalTasks > 10){
                alert('Please complete the upcoming task.');
            } else {
                const newTask = {
                    title: this.newUpcomingTask,
                    taskId: `${newTaskID}`,
                    waiting: true,
                };

                fetch('/api/upcoming', {
                    method: 'POST',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                    body:JSON.stringify(newTask)
                })
                .then(()=>{this.upcomingTasks.push(newTask)})
                .catch(error => console.log(error));;
            }

            // erase new tasks
            this.newUpcomingTask = "";
        },                
        deleteUpcomingTask(taskId){
            let confirmMessage = `Are you sure you want to delete task ${taskId}`;
            if( confirm(confirmMessage) ){
                fetch(`/api/upcoming/${taskId}`,{
                    method:'DELETE',
                })
                .then( response => response.json())
                .then(() => {
                    this.upcomingTasks = this.upcomingTasks.filter(
                        ({taskId : id}) => (id !== taskId)
                    );
                } )
                .catch( error => console.log(error) );
            }
        },
        checkUpcomingTask(taskId){
            if(this.todayTasks.length > 8){
                alert('Sorry. Please complete existing task. Maximum current tasks are 8');
                window.location.href="/";
            } else{
                this.addTodayTaskFromUpcomingList(taskId);
                
                // Delete this task from Database
                fetch(`/api/upcoming/${taskId}`,{
                    method:'DELETE',
                })
                .then( response => response.json())
                .then(() => {
                    this.upcomingTasks = this.upcomingTasks.filter(
                        ({taskId : id}) => (id !== taskId)
                    );
                } )
                .catch( error => console.log(error) );
            }
        },
        updateUpcomingTask(taskId, taskTitle){
            const updatedTask = {
                title: taskTitle,
                completed: false,
                approved: true,                                
                waiting: true
            };

            fetch(`/api/upcoming/updatebyid/${taskId}`, {
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                },
                body:JSON.stringify(updatedTask)
            })
            .then(response => response.json())
            .catch(error => console.log(error));
        },
        toggleEditTitleUpcomingTask(taskId){
            // task Id OK
            let editItemSelector = `ul#crmlaravel-upcoming-tasks-list li div.info div.left h4#${taskId}`;
            let documentSelector = this;
            let editItem = document.querySelector(editItemSelector);
            //let editItemTitleOriginal = editItem.textContent;

            let editableStatus = editItem.getAttribute('contenteditable');

            // Toggle editable status:
            switch(editableStatus){
                case 'true':
                    editItem.setAttribute('contenteditable', 'false');
                    editItem.parentElement.style.backgroundColor = 'transparent';    

                    editItem.removeEventListener("keypress", function(event) {                        
                        if (event.keyCode === 13) {
                            event.preventDefault();                            
                        }
                    });            
                    break;
                case 'false':
                    editItem.setAttribute('contenteditable', 'true');
                    editItem.parentElement.style.backgroundColor = '#33ff3320'; // green
                    
                    editItem.addEventListener("keypress", function(event) {                        
                        if (event.keyCode === 13) {
                            event.preventDefault();     
                            //console.log('Enter is pressed ! Complete editing task item');

                            editItem.setAttribute('contenteditable', 'false');     
                            editItem.parentElement.style.backgroundColor = 'transparent'; 
                            
                            documentSelector.updateUpcomingTask(taskId, editItem.textContent);                            
                        }
                    });
                    break;
                default:
                    editItem.setAttribute('contenteditable', 'false');
            }

            // If editable status is false, then do nothing
            if('false' === editItem.getAttribute('contenteditable')) return ;


        },

        //** II. Today task **//
        // 1. Get all tasks
        fetchTodayTasks(){
            fetch('/api/dailytask')
            .then(response => response.json())
            .then(({data}) => {
                this.todayTasks = data;
                //console.log(data);
            })
            .catch(error => console.log(error));
        },
        // 2. Add new today task
        async addTodayTaskFromUpcomingList(taskId){
            const task = this.upcomingTasks.filter( ({taskId : id}) => id == taskId )[0];
            
            fetch('/api/dailytask', {
                method:'POST',
                headers:{
                    'Accept':'application/json',
                    'Content-Type':'application/json',
                },
                body: JSON.stringify(task)
            })
            .then(
                async () => {
                    // this.todayTasks.push(task); // duplicate key using ID
                    // 1. append the new tasks
                    //this.todayTasks[taskKey] = task; // OK but cannot update by default

                    // 2. Push the new task to the beginning
                    this.todayTasks.unshift(task); // The object is already in proper order

                    //console.log(this.todayTasks);

                    // refresh the whole page. Only this method work ...
                    //window.location.hash = '#crmlaravel-today-tasks';
                    //window.location.reload(); //OK but need to reload the whole page
                }
            )
            .catch(error => console.log(error));
            // console.log(task);
        },
        async addTodayTask(e){
            e.preventDefault();

            let totalTasks = this.todayTasks.length;            

            let newTaskID = `TASKID-${zeroPadding(totalTasks + 1,3)}-${getRandomString(10)}`;
            //let newTaskID = 'TASK-ID-003-ETGfXelSBP'; // test on existing item
            // check newTaskID existed
            let queryTaskId = await fetch(`/api/dailytask/searchbyid?taskId=${newTaskID}`,{
                    method: 'GET',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                })
                .then(response => response.json())            
                .catch(error => console.log(error));            
            
            // if empty array & length = 0, proceed adding new item
            
            let queryResult = Array.isArray(queryTaskId.data[0]) ? queryTaskId.data[0] : Array(queryTaskId.data[0]);
           
            // if has object existed with same ID, generate another ID
            while(queryResult.length > 0){
                console.log('New task ID detected. Generate another task Id');
                newTaskID = `TASKID-${zeroPadding(totalTasks + 1,3)}-${getRandomString(10)}`;

                queryTaskId = await fetch(`/api/dailytask/searchbyid?taskId=${newTaskID}`,{
                    method: 'GET',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                })
                .then(response => response.json())            
                .catch(error => console.log(error));

                queryResult = Array.isArray(queryTaskId.data[0]) ? queryTaskId.data[0] : Array.from(queryTaskId.data[0]);
            } 
          
            // Task ID: TASKID-003-<random_string>
            if(totalTasks > 10){
                alert('Please complete the upcoming task.');
            } else {
                const newTask = {
                    title: this.newTodayTask,
                    taskId: `${newTaskID}`,                    
                };

                fetch('/api/dailytask', {
                    method: 'POST',
                    headers:{
                        'Accept':'application/json',
                        'Content-Type':'application/json',
                    },
                    body:JSON.stringify(newTask)
                })
                .then(()=>{this.todayTasks.push(newTask)})
                .catch(error => console.log(error));;
            }

            // erase new tasks
            this.newTodayTask = "";
        },  
        updateTodayTask(taskId, taskTitle){
            const updatedTask = {
                title: taskTitle,
                completed: false,
                approved: true,                                
                waiting: true
            };

            fetch(`/api/dailytask/updatebyid/${taskId}`, {
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                },
                body:JSON.stringify(updatedTask)
            })
            .then(response => response.json())
            .catch(error => console.log(error));
        },
        // 3. Delete today tasks
        deleteTodayTask(taskId){
            let confirmMessage = `Are you sure you want to delete task ${taskId}`;
            if( confirm(confirmMessage) ){
                fetch(`/api/dailytask/${taskId}`,{
                    method:'DELETE',
                })
                .then( response => response.json())
                .then(() => {
                    this.todayTasks = this.todayTasks.filter(
                        ({taskId : id}) => (id !== taskId)
                    );
                } )
                .catch( error => console.log(error) );
            }
        },
        // 4. Update completion today task
        updateCompletionTodayTask(taskId){
            const updatedTask = this.todayTasks.filter( ({taskId : id}) => id == taskId )[0];

            // Toggle the task completed status
            if(0 === updatedTask.completed){
                updatedTask.completed = 1;
            } else if (1 === updatedTask.completed){
                updatedTask.completed = 0;
            } else {
                updatedTask.completed = 0;
            }

            //console.log(task);

            fetch(`/api/dailytask/updatebyid/${taskId}`, {
                method:'POST',
                headers:{
                    'Accept':'application/json',
                    'Content-Type':'application/json',
                },
                body: JSON.stringify(task)
            });
        },
        toggleEditTitleTodayTask(taskId){
            // task Id OK
            let editItemSelector = `ul#crmlaravel-today-tasks-list li div.info div.left h4#${taskId}`;
            let documentSelector = this;

            let editItem = document.querySelector(editItemSelector);
            //let editItemTitleOriginal = editItem.textContent;

            let editableStatus = editItem.getAttribute('contenteditable');

            // Toggle editable status:
            switch(editableStatus){
                case 'true':
                    editItem.setAttribute('contenteditable', 'false');
                    editItem.parentElement.style.backgroundColor = 'transparent';    

                    editItem.removeEventListener("keypress", function(event) {                        
                        if (event.keyCode === 13) {
                            event.preventDefault();                            
                        }
                    });            
                    break;
                case 'false':
                    editItem.setAttribute('contenteditable', 'true');
                    editItem.parentElement.style.backgroundColor = '#33ff3320'; // green
                    
                    editItem.addEventListener("keypress", function(event) {                        
                        if (event.keyCode === 13) {
                            event.preventDefault();     
                            //console.log('Enter is pressed ! Complete editing task item');

                            editItem.setAttribute('contenteditable', 'false');     
                            editItem.parentElement.style.backgroundColor = 'transparent';                             
                           
                            documentSelector.updateTodayTask(taskId, editItem.textContent);     
                                 
                        }
                    });
                    break;
                default:
                    editItem.setAttribute('contenteditable', 'false');
            }

            // If editable status is false, then do nothing
            if('false' === editItem.getAttribute('contenteditable')) return ;


        },
    }
}
</script>

<style>

</style>
