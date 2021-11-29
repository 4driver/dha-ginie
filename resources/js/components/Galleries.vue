<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Galleries List</h3>

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
                    <th>Title</th>
                    <th>Image</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="gallery in galleries.data" :key="gallery.id">
                    <td>{{ gallery.id }}</td>
                    <td class="text-capitalize">{{ gallery.title }}</td>
                    <td>{{ gallery.image }}</td>
                    <td>
                      <a href="#" @click="editModal(gallery)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteGallery(gallery.id)">
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
                :data="galleries"
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
              <h5 class="modal-title" v-show="!editmode">Add New Record</h5>
              <h5 class="modal-title" v-show="editmode">Update Record</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateGallery() : createGallery()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Title</label>
                  <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"/>
                  <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <input v-model="form.image" type="text" name="image" class="form-control" :class="{ 'is-invalid': form.errors.has('image') }"/>
                  <has-error :form="form" field="image"></has-error>
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
      galleries: {},
      form: new Form({
        id: "",
        title: "",
        image: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/gallery?page=" + page)
        .then(({ data }) => (this.galleries = data.data));

      this.$Progress.finish();
    },
    updateGallery() {
      this.$Progress.start();
      this.form
        .put("api/gallery/" + this.form.id)
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadGalleries();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(faq) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(faq);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteGallery(id) {
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
            .delete("api/gallery/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadGalleries();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadGalleries() {
      this.$Progress.start();
      if (this.$gate.isAdmin()) {
        axios.get("api/gallery").then(({ data }) => (this.galleries = data.data));
      }
      this.$Progress.finish();
    },
    createGallery() {
      this.form
        .post("api/gallery")
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadGalleries();
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
    console.log("GALLERIES COMPONENT - SUCCESS");
  },

  created() {
    this.$Progress.start();
    this.loadGalleries();
    this.$Progress.finish();
  },
};
</script>
