<template>
    <div>

        <form class="text-center"  @submit.prevent="editN(note)" v-if="activateEdit"> 
        <h3>Edit</h3>
            <input type="text" placeholder="First Name" class="from-control mb-2" v-model="note.firstname"> <br>
            <input type="text" placeholder="Description" class="from-control mb-2" v-model="note.description"> <br>
            <button class="btn btn-success" type="submit">Save</button>
            <button class="btn btn-danger" @click="cancelEdit()" type="submit">Cancel</button>

        </form>

        <form class="text-center"  @submit.prevent="add" v-else > 
            <h3 class="card text-white bg-primary mb-2"  >Add Tasks</h3>
            <input type="text" placeholder="Name" class="from-control mb-2" v-model="note.firstname"> <br>
            <input type="text" placeholder="Description" class="from-control mb-2" v-model="note.description"> <br>
            <button class="btn btn-primary" type="submit">Add</button>
        </form>

        <hr clas="mt-3">
            <ul class="list-group my-2">

            <li class="list-group-item "  v-for="(item, index) in information" :key="index">
                 <div class="text-center">
                <p>{{item.firstname}}</p>
                <p>{{item.description}}</p>
                {{item.updated_at}}<br>
               
                <button class="btn btn-outline-primary" @click="remove(item, index)">Delete</button>
           
                <button class="btn btn-info " @click="edit(item)">Edit</button>
                </div>
           
            </li>
        </ul>


    </div>
</template>

<script>
export default {
    data(){
       return{
        information: [],
        note:{firstname: '', description: ''},
        activateEdit: false
      }
    },
    created(){
        axios.get('information')
        .then(res=> {
            this.information = res.data;
        })

    },

    methods:{
        edit(item){
            this.activateEdit = true;
            this.note.firstname = item.firstname;
            this.note.description = item.description;
            this.note.id = item.id;
        },
        
        editN(item){
            
            const params = {firstname: item.firstname, description: item.description}
            axios.put(`/information/${item.id}`, params).then(res => {
                const index = this.information.findIndex(search => search.id === res.data.id)
                this.information[index] = res.data;

                this.note ={firstname: '', description: ''}

            })
        },
        cancelEdit(){
            this.activateEdit = false;


        },

        add(){
            if(this.note.firstname.trim() === '' || this.note.description.trim() === ''){
        alert('You must complete all fields before saving');
        return;
      }
            // console.log(this.note.firstname, this.note.description);
            const params = {
                firstname: this.note.firstname,
                description: this.note.description
                }
                this.note.firstname='';
                this.note.description='';
                
                axios.post('/information', params).then(res =>{
                this.information.push(res.data)

            } )
        },

        remove(item, index){
            axios.delete(`/information/${item.id}`).then(()=>{this.information.splice(index, 1)});


        }
    }
}
</script>