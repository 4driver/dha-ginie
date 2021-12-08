<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Subscriptions List</h3>

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
                    <th>Title</th>
                    <th>Services</th>
                    <th>Price</th>
                    <th>Offer</th>
                    <th>Visits</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="pkg in packages.data" :key="pkg.id">
                    <td>{{ pkg.id }}</td>
                    <td class="text-capitalize">{{ pkg.title }}</td>
                    <td class="text-capitalize">{{ pkg.services }}</td>
                    <td class="text-capitalize">{{ pkg.price }}</td>
                    <td class="text-capitalize">{{ pkg.offer_price }}</td>
                    <td class="text-capitalize">{{ pkg.visits }}</td>
                    <td class="text-capitalize">{{ pkg.duration }}</td>
                    <td class="text-capitalize">{{ pkg.description }}</td>
                    <td class="text-capitalize">
                         <span v-if="pkg.status == 1" class="badge badge-success">Active</span>
                        <span v-else class="badge badge-danger">Inactive</span>
                    </td>
                    <td>
                      <a href="#" @click="editModal(pkg)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteService(pkg.id)">
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
                :data="packages"
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
                  <label>Title</label>
                  <input
                    v-model="form.title"
                    type="text"
                    name="title"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('title') }"
                  />
                  <has-error :form="form" field="title"></has-error>
                </div>

                <div class="form-group">
                  <label>Services</label>
                  <input
                    v-model="form.services"
                    type="text"
                    name="services"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('services') }"
                  />
                  <has-error :form="form" field="services"></has-error>
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

                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label>No. of Visits</label>
                        <input
                            v-model="form.visits"
                            type="number"
                            min="0"
                            name="visits"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('visits') }"
                        />
                        <has-error :form="form" field="visits"></has-error>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label>Duration</label>
                        <input
                            v-model="form.duration"
                            type="text"
                            min="0"
                            name="duration"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('duration') }"
                        />
                        <has-error :form="form" field="duration"></has-error>
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

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" v-model="form.status" id="status" class="form-control custom-select"
                  :class="{ 'is-invalid': form.errors.has('status') }">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
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
      packages: {},
      form: new Form({
        id: "",
        title: "",
        services: "",
        price: "",
        offer_price: "",
        visits: "",
        duration: "",
        description: "",
        status: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/package?page=" + page)
        .then(({ data }) => (this.packages = data.data));

      this.$Progress.finish();
    },
    updateService() {
      this.$Progress.start();
      this.form
        .put("api/package/" + this.form.id)
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadPackages();
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
            .delete("api/package/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadPackages();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadPackages() {
      this.$Progress.start();

      if (this.$gate.isAdmin()) {
        axios.get("api/package").then(({ data }) => (this.packages = data.data));
      }

      this.$Progress.finish();
    },
    createService() {
      this.form
        .post("api/package")
        .then((response) => {
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: response.data.message,
          });

          this.$Progress.finish();
          this.loadPackages();
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
    this.loadPackages();
    this.$Progress.finish();
  },
};
</script>
