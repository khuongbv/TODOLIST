<template>
  <div>
    <div>
      <h1>Todo App</h1>
      <div class="notice" v-if="message !== ''">
        {{message}}
      </div>
      <button class="btn btn-success btn-add" data-toggle="modal" data-target="#exampleModalCenter">Add</button>
      <table class="table">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">#</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products"
            class="todo"
            v-bind:key="product.key">
                <th scope="row">{{ product.id }}</th>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>
                    <button class="btn btn-success" 
                    data-toggle="modal" data-target="#updateModalCenter"
                    @click="edit(product.id, product.name, product.description, product.price)">Edit</button>
                    <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                </td>
            </tr>
        </tbody>
        </table>

        <!-- Modal add-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add new product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method="POST" @submit.prevent="onSubmit()">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputName">Name</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control" id="exampleInputName" v-model="name" placeholder="Enter Name">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputDescription">Description</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control" id="exampleInputDescription" v-model="description" placeholder="Enter Description">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputPrice">Price</label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" class="form-control" id="exampleInputPrice" v-model="price" placeholder="Enter Price">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" @click="onSubmit()" data-dismiss="modal">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </form>
              </div>
              </div>
          </div>
        </div>

        <!-- Modal update-->
        <div class="modal fade" id="updateModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add new product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form method="POST" @submit.prevent="update(product.update_id, this.price, this.description, this.price)">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputName">Name</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control" id="exampleInputName" v-model="update_name" placeholder="Enter Name">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputDescription">Description</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control" id="exampleInputDescription" v-model="update_description" placeholder="Enter Description">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleInputPrice">Price</label>
                        </div>
                        <div class="col-md-9">
                          <input type="number" class="form-control" id="exampleInputPrice" v-model="update_price" placeholder="Enter Price">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" @click="update()" data-dismiss="modal">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </form>
              </div>
              </div>
          </div>
        </div>

      </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Todos",
        data() {
            return { 
                products: [],
                name: '',
                description: '',
                price: '',
                update_id: '',
                update_name: '',
                update_description: '',
                update_price: '',
                message: '',
                error: false
            }
        },
        // created(){
        //     this.getProducts();
        // },
        mounted: function() {
            this.getProducts();
        },
        methods:{
            // ...mapActions(["fetchTodos", "deleteTodo"]),
            getProducts(){
               axios.get('http://localhost/vue-project/todolist/api/index.php?controller=product&action=index')
                .then(response => {
                    this.products = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                }); 
            },
            edit(id, product_name, product_description, product_price) {
              this.update_name = product_name;
              this.update_description = product_description;
              this.update_price = product_price;
              this.update_id = id;
            }
            ,
            update() {
                var formData = new FormData();
                formData.append('id', this.update_id);
                formData.append('name', this.update_name);
                formData.append('description', this.update_description);
                formData.append('price', this.update_price);
                console.log(formData);
                axios({
                    url: 'http://localhost/vue-project/todolist/api/index.php?controller=product&action=update',
                    method: 'post',
                    data: formData
                }).then(res => {
                    console.log(res.data);
                    this.message = res.data.message;
                    this.error = false;
                    this.getProducts();
                }).catch(err => {
                    console.log(err);
                })
            },
            deleteProduct(id) {
                if(window.confirm("Delete this record?")) {
                    var formData = new FormData();
                    formData.append('id', id);
                    axios({
                        url: 'http://localhost/vue-project/todolist/api/index.php?controller=product&action=delete',
                        method: 'post',
                        data: formData
                    }).then(res => {
                        console.log(res);
                        this.message = res.data.message;
                        this.getProducts();
                    }).catch(err => {
                        console.log(err);
                    })
                }
            },
            onSubmit() {
                if(this.name !== '' && this.description !== '' && this.price !== '') {
                    var formData = new FormData();
                    formData.append('name', this.name);
                    formData.append('description', this.description);
                    formData.append('price', this.price);
                    axios({
                        url: 'http://localhost/vue-project/todolist/api/index.php?controller=product&action=create',
                        method: 'post',
                        data: formData  
                    }).then(res => {
                        console.log(res);
                        this.message = res.data.message;
                        this.getProducts();
                    }).catch(err => {
                        console.log(err);
                    })
                }
            }
        }
    };
</script>

<style scoped>
  h1{ 
      text-align: center;
      background-color: bisque;
      padding: 10px 0;
  }
  table {
      width: 80%;
      margin: 0 auto;
  }
  .btn-add { 
      margin-left: 133px;
      padding: 6px 20px;
  }

  .notice {
    text-align: center;
    border: 1px solid green;
    background-color: green;
    color: white;
    font-size: 1.2em;
    width: 25%;
    position: fixed;
    top: 69px;
    right: 0;
    border-radius: 5px;
  }
</style>