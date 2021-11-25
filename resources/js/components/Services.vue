<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Services List</h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="newModal">
                  <i class="fa fa-plus-square mr-1"></i>
                  Add New
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="service in services.data" :key="service.id">
                    <td>{{ service.id }}</td>
                    <td class="text-capitalize">{{ service.name }}</td>
                    <td>{{ service.category }}</td>
                    <td>{{ service.description }}</td>
                    <td>
                      <a href="#" @click="editModal(service)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteService(service.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination
                :data="users"
                @pagination-change-page="getResults"
              ></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>

      <div v-if="!$gate.isAdmin()">
        <not-found></not-found>
      </div>

      <!-- Modal -->
      <div
        class="modal fade"
        id="addNew"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNew"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode">Add New Service</h5>
              <h5 class="modal-title" v-show="editmode">Update Service</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateService() : createService()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <input
                    v-model="form.description"
                    type="text"
                    name="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                  />
                  <has-error :form="form" field="description"></has-error>
                </div>

                <div class="form-group">
                  <label>Category</label>
                  <select
                    name="category"
                    v-model="form.category"
                    id="category"
                    class="form-control custom-select"
                    :class="{ 'is-invalid': form.errors.has('category') }"
                  >
                    <option value="">Select Category</option>
                    <option value="cat_1">Category 1</option>
                    <option value="cat_2">Category 2</option>
                  </select>
                  <has-error :form="form" field="category"></has-error>
                </div>

              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button v-show="editmode" type="submit" class="btn btn-primary">
                  Update
                </button>
                <button
                  v-show="!editmode"
                  type="submit"
                  class="btn btn-primary"
                >
                  Create
                </button>
              </div>
            </form>
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
      services: {},
      form: new Form({
        id: "",
        name: "",
        category: "",
        description: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/service?page=" + page)
        .then(({ data }) => (this.services = data.data));

      this.$Progress.finish();
    },
    updateService() {
      this.$Progress.start();
      // console.log('Editing data');
      this.form
        .put("api/service/" + this.form.id)
        .then((response) => {
          // success
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          //  Fire.$emit('AfterCreate');

          this.loadServices();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(service) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(service);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteService(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          this.form
            .delete("api/service/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              // Fire.$emit('AfterCreate');
              this.loadServices();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadServices() {
      this.$Progress.start();

      if (this.$gate.isAdmin()) {
        axios.get("api/service").then(({ data }) => (this.services = data.data));
      }

      this.$Progress.finish();
    },
    createService() {
      this.form
        .post("api/service")
        .then((response) => {
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: response.data.message,
          });

          this.$Progress.finish();
          this.loadServices();
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
    console.log("Service Component mounted.");
  },

  created() {
    this.$Progress.start();
    this.loadServices();
    this.$Progress.finish();
  },
};
</script>
