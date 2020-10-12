<template>
    <div>
        <h1 class="mt-2 mb-2">Profile</h1>
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
            <!-- <button class="btn btn-primary btn-block" style="width:200px;margin:auto;">Save</button> -->
    </div>
</template>

<script>
export default {
    props: ["authToken","userId"],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
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
            access_token: ""
        };
    },

    created() {
        this.access_token = this.authToken;
        this.userId = this.user_id
        console.log(this.access_token);
        this.fetchDetails();
    },
    methods: {
        fetchDetails() {
            fetch(`api/user/${this.user_id}`, {
                headers: {
                    "content-type": "application/json",
                    Authorization: `Bearer ${this.access_token}`
                }
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    this.user.firstname = data.firstname;
                    this.user.lastname = data.lastname;
                    this.user.role = data.role;
                    this.user.address = data.address;
                    this.user.postcode = data.postcode;
                    this.user.contact_number = data.contact_number;
                    this.user.username = data.username;
                    this.user.email = data.email;
                });
        }
    }
};
</script>
