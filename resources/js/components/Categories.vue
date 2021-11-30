<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Categories List</h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-sm btn-primary"
                  @click="newModal"
                >
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
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="task in tasks.data" :key="task.id">
                    <td>{{ task.id }}</td>
                    <td class="text-capitalize">{{ task.name }}</td>
                    <td class="text-capitalize">{{ task.description }}</td>

                    <td>
                      <a href="#" @click="editModal(task)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteTask(task.id)">
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
                :data="tasks"
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
              <h5 class="modal-title" v-show="!editmode">Add New Category</h5>
              <h5 class="modal-title" v-show="editmode">Update Category</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateCategory() : createCategory()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"/>
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Description</label>
                  <textarea v-model="form.description" rows="5" type="text" name="description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"/>
                  <has-error :form="form" field="description"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
      tasks: {},
      form: new Form({
        id: "",
        name: "",
        description: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/category?page=" + page)
        .then(({ data }) => (this.tasks = data.data));

      this.$Progress.finish();
    },
    updateCategory() {
      this.$Progress.start();
      this.form
        .put("api/category/" + this.form.id)
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadCategories();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteTask(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          this.form
            .delete("api/category/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadCategories();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadCategories() {
      this.$Progress.start();
      if (this.$gate.isAdmin()) {
        axios.get("api/category").then(({ data }) => (this.tasks = data.data));
      }
      this.$Progress.finish();
    },
    createCategory() {
      this.form
        .post("api/category")
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadCategories();
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
    console.log("TASK COMPONENT - SUCCESS");
  },

  created() {
    this.$Progress.start();
    this.loadCategories();
    this.$Progress.finish();
  },
};
</script>
