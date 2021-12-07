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
                    <td>{{ service.category.name }}</td>
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
                :data="services"
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
                  <label>Category</label>
                  <select
                    name="category_id"
                    v-model="form.category_id"
                    id="category_id"
                    class="form-control custom-select"
                    :class="{ 'is-invalid': form.errors.has('category_id') }"
                  >
                    <option value="">Select Category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                  </select>
                  <has-error :form="form" field="category_id"></has-error>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label>Price</label>
                        <input
                            v-model="form.price"
                            type="number"
                            min="0"
                            name="price"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('price') }"
                        />
                        <has-error :form="form" field="price"></has-error>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label>Offer Price</label>
                        <input
                            v-model="form.offer_price"
                            type="number"
                            min="0"
                            name="offer_price"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('offer_price') }"
                        />
                        <has-error :form="form" field="offer_price"></has-error>
                    </div>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea
                    v-model="form.description"
                    type="text"
                    name="description"
                    class="form-control"
                    rows="5"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                  />
                  <has-error :form="form" field="description"></has-error>
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
      categories: {},
      form: new Form({
        id: "",
        name: "",
        price: "",
        offer_price: "",
        category_id: "",
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
      this.form
        .put("api/service/" + this.form.id)
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
        if (result.value) {
          this.form
            .delete("api/service/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadServices();
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
        axios.get("api/getCategories").then(({ data }) => (this.categories = data.data));
      }

      this.$Progress.finish();
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
    console.log("SERVICE COMPONET - SUCCESS");
  },

  created() {
    this.$Progress.start();
    this.loadCategories();
    this.loadServices();
    this.$Progress.finish();
  },
};
</script>
