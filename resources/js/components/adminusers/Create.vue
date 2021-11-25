<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Admin User</h3>
                        </div>
                        <div class="card-body">
                        <form @submit.prevent="createUser()">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label>Name <span class="required-star">*</span></label>
                                    <input type="text" maxlength="100" class="form-control" name="name" required v-model="form.name">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label>Email <span class="required-star">*</span></label>
                                    <input type="email" class="form-control " name="email" required v-model="form.email">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label>Phone <span class="required-star">*</span></label>
                                    <input type="text" class="form-control" name="phone" required v-model="form.phone">
                                </div>
                                <!-- <div class="form-group col-md-6">
                                    <label>Permissions <span class="required-star">*</span></label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" data-placeholder="Nothing Selected"
                                            name="permissions[]" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;" required>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label>Password <span class="required-star">*</span></label>
                                    <input type="password" id="password" class="form-control" name="password" required v-model="form.password">
                                </div>
                                <!-- <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <label>Confirm Password <span class="required-star">*</span></label>
                                    <input id="password_confirm" type="password" class="form-control" name="password_confirmation" required v-model="form.password_confirmation">
                                </div> -->
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary float-right">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      users: {},
      form: new Form({
        name: "",
        email: "",
        phone: "",
        password: "",
      }),
    };
  },
  methods: {
    createUser() {
      this.form
        .post("/api/admin-user")
        .then((response) => {
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });

          this.$Progress.finish();
        })
        .catch(() => {
          Toast.fire({
            icon: "error",
            title: "Some error occured! Please try again",
          });
        });
    },
  },
  mounted() {
    console.log("User Component mounted.");
  },
  created() {
    this.$Progress.start();
    this.loadUsers();
    this.$Progress.finish();
  },
};
</script>
