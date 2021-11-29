<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" v-if="$gate.isAdmin()">
            <div class="card-header">
              <h3 class="card-title">Faqs List</h3>

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
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="faq in faqs.data" :key="faq.id">
                    <td>{{ faq.id }}</td>
                    <td class="text-capitalize">{{ faq.title }}</td>
                    <td>{{ faq.question }}</td>
                    <td>{{ faq.answer }}</td>

                    <td>
                      <a href="#" @click="editModal(faq)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteFaq(faq.id)">
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
                :data="faqs"
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
              <h5 class="modal-title" v-show="!editmode">Add New Task</h5>
              <h5 class="modal-title" v-show="editmode">Update Task</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateFaq() : createFaq()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Title</label>
                  <input v-model="form.title" type="text" name="title" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"/>
                  <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                  <label>Question</label>
                  <textarea v-model="form.question" type="text" rows="2" name="question" class="form-control" :class="{ 'is-invalid': form.errors.has('question') }"/>
                  <has-error :form="form" field="question"></has-error>
                </div>
                <div class="form-group">
                  <label>Answer</label>
                  <textarea v-model="form.answer" rows="5" type="text" name="answer" class="form-control" :class="{ 'is-invalid': form.errors.has('answer') }"/>
                  <has-error :form="form" field="answer"></has-error>
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
      faqs: {},
      form: new Form({
        id: "",
        title: "",
        question: "",
        answer: "",
      }),
    };
  },

  methods: {
    getResults(page = 1) {
      this.$Progress.start();

      axios
        .get("api/faq?page=" + page)
        .then(({ data }) => (this.faqs = data.data));

      this.$Progress.finish();
    },
    updateFaq() {
      this.$Progress.start();
      this.form
        .put("api/faq/" + this.form.id)
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadFaqs();
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
    deleteFaq(id) {
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
            .delete("api/faq/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.loadFaqs();
            })
            .catch((data) => {
              Swal.fire("Failed!", data.message, "warning");
            });
        }
      });
    },
    loadFaqs() {
      this.$Progress.start();
      if (this.$gate.isAdmin()) {
        axios.get("api/faq").then(({ data }) => (this.faqs = data.data));
      }
      this.$Progress.finish();
    },
    createFaq() {
      this.form
        .post("api/faq")
        .then((response) => {
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.$Progress.finish();
          this.loadFaqs();
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
    console.log("FAQ COMPONENT - SUCCESS");
  },

  created() {
    this.$Progress.start();
    this.loadFaqs();
    this.$Progress.finish();
  },
};
</script>
