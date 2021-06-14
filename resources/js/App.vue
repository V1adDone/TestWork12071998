<template>
    <div id="app">
        <div class="container">
            <div class="row mt-5 justify-content-center" id="mute">
                <div class="col-12 col-lg-8">
                    <h3 class="text-center mb-4">Products</h3>
                </div>

                <div class="col-12">
                    <table class="table table-hover nowrap rounded shadow-xs border-xs mt-2">
                        <thead class="table-borderless">
                            <td class="col-1">#</td>
                            <td>Title</td>
                            <td>Price</td>
                            <td>Actions</td>
                        </thead>
                        <tbody>
                            <product-component
                                v-for="product in products"
                                v-bind="product"
                                :key="product.id"
                                @update="update"
                                @delete="del"
                            ></product-component>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" @click="create">Add product</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  function Product({ id, title, price }) {
    this.id = id;
    this.title = title;
    this.price = price;
  }

  import ProductComponent from './components/ProductComponent.vue';

  export default {
    data() {
      return {
        products: [],
        mute: false
      }
    },
    methods: {
      async create() {
        this.mute = true;
        const { data } = await window.axios.get('/api/products/create');
        this.products.push(new Product(data));
        this.mute = false;
      },
      async read() {
        this.mute = true;
        const { data } = await window.axios.get('/api/products');
        data.forEach(product => this.products.push(new Product(product)));
        this.mute = false;
      },
      async update(id, title, price) {
        this.mute = true;
        await window.axios.put(`/api/products/${id}`, { title, price }).catch(error => {
            if (error.response.data.errors) {
                let errorMessage = 'Validation errors:';
                for (const [key, value] of Object.entries(error.response.data.errors)) {
                  errorMessage += "\n" + `${value}`;
                }
                alert(errorMessage);
            }
        });
        let product = this.products.find(product => product.id === id);
        product.title = title;
        product.price = price;
        this.mute = false;
      },
      async del(id) {
        this.mute = true;
        await window.axios.delete(`/api/products/${id}`);
        let index = this.products.findIndex(product => product.id === id);
        this.products.splice(index, 1);
        this.mute = false;
      }
    },
    watch: {
      mute(val) {
        if (val) {
            document.getElementById('mute').classList.add('on');
        } else {
            document.getElementById('mute').classList.remove('on');
        }
      }
    },
    components: {
      ProductComponent
    },
    created() {
      this.read();
    }
  }
</script>

<style>
    #app {
        position: relative;
    }
    #mute.on {
        opacity: 0.3;
    }
    .table td {
        text-align: center;
    }
    .table thead td {
        font-weight: bold;
    }
</style>
