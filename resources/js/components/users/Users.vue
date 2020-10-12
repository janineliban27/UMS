<template>
    <div>
        <h1 class="mt-2 mb-2">Users</h1>
           <form class="mb-4" @submit.prevent="addUser">
            <div class="col-lg-12">
                 <div class="row">
                    <div class="form-group col-md-4">
                        <input v-model="user.username" type="text" class="form-control" placeholder="Username"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input v-model="user.email"  type="email" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input v-model="user.password"  type="password" class="form-control" placeholder="Password" />
                    </div>
                 </div>
             </div>
             <div class="col-lg-12">
                 <div class="row">
                    <div class="form-group col-md-4">
                        <input v-model="user.firstname"  type="text" class="form-control" placeholder="Firstname"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input v-model="user.lastname"  type="text" class="form-control" placeholder="Lastname" />
                    </div>
                    <div class="form-group col-md-4">
                        <select v-model="user.role" class="form-control">
                            <option value="standard">Standard</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                 </div>
             </div>
            <div class="col-lg-12">
                 <div class="row">
                    <div class="form-group col-md-4">
                        <input v-model="user.address"  type="text" class="form-control" placeholder="Address"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input v-model="user.postcode"  type="text" class="form-control" placeholder="Postcode" />
                    </div>
                     <div class="form-group col-md-4">
                        <input v-model="user.contact_number"  type="text" class="form-control" placeholder="Contact Number" />
                    </div>
                 </div>
             </div>
            <input type="hidden" name="_token" :value="csrf">
            <button class="btn btn-primary btn-block" style="width:200px;margin:auto;">Save</button>
        </form>
        <div class="table-responsive">
        <table class="table table-striped" >
            <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Postcode</th>
                <th>Contact Number</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr  v-for="user in users"
            v-bind:key="user.id">
                <td>{{user.firstname}}</td>
                <td>{{user.lastname}}</td>
                <td>{{user.username}}</td>
                <td>{{user.email}}</td>
                <td>{{user.address}}</td>
                <td>{{user.postcode}}</td>
                <td>{{user.contact_number}}</td>
                <td>{{user.role}}</td>
                <td>
                        <button class="btn btn-block btn-warning mb-2" @click="editUser(user)">
                            Edit
                        </button>
                         <button class="btn btn-block btn-danger" @click="deleteUser(user.id)">
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["authToken"],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            users: [],
            user: {
                id: "",
                firstname: "",
                lastname: "",
                role: "",
                address: "",
                postcode: "",
                contact_number: "",
                username: "",
                email: "",
                password: "",
            },
            user_id: "",
            // pagination: {},
            edit: false,
            access_token: ""
        };
    },

    created() {
        this.access_token = this.authToken;
        console.log(this.access_token);
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            fetch("api/users", {
                headers: {
                    "content-type": "application/json",
                    Authorization: `Bearer ${this.access_token}`
                }
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    this.users = data;
                });
        },
        deleteUser(id) {
            if (confirm("Are you sure")) {
                fetch(`api/user/delete/${id}`, {
                    method: "put",
                    headers: {
                        "content-type": "application/json",
                        Authorization: `Bearer ${this.access_token}`
                    }
                })
                    .then(res => res)
                    .then(res => {
                        alert("user removed");
                        this.fetchUsers();
                    });
            }
        },
        addUser() {
            if (this.edit == false) {
                //add
                fetch("api/user/store", {
                    method: "post",
                    body: JSON.stringify(this.user),
                    headers: {
                         "content-type": "application/json",
                        Authorization: `Bearer ${this.access_token}`
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        this.user.firstname = "";
                        this.user.lastname = "";
                        this.user.username = "";
                        this.user.email = "";
                        this.user.password = "";
                        this.user.address = "";
                        this.user.contact_number = "";
                        this.user.role = "";
                        this.user.postcode = "";
                        alert("user created!");
                        this.fetchUsers();
                    });
            } 
            else {
                //update
                fetch(`api/user/update/${this.user_id}`, {
                    method: "put",
                    body: JSON.stringify(this.user),
                    headers: {
                        "content-type": "application/json",
                         Authorization: `Bearer ${this.access_token}`
                      
                    }
                })
                    .then(res => res.json())
                    .then(res => {
                        this.edit = false;
                        this.user_id = "";
                        this.user.firstname = "";
                        this.user.lastname = "";
                        this.user.username = "";
                        this.user.email = "";
                        this.user.password = "";
                        this.user.address = "";
                        this.user.contact_number = "";
                        this.user.role = "";
                        this.user.postcode = "";
                        alert("user updated!");
                        this.fetchUsers();
                    });
            }
        },
        editUser(user) {
            this.edit = true;
            this.user.id = user.id;
            this.user_id = user.id;
            this.user.firstname = user.firstname;
            this.user.lastname = user.lastname;
            this.user.email = user.email;
            this.user.username = user.username;
            this.user.address = user.address;
            this.user.postcode = user.postcode;
            this.user.contact_number = user.contact_number;
            this.user.role = user.role;
        },
    }
};
</script>
<style scoped>
table{
    width:100% !important;
    font-size:13px !important;
}
</style>