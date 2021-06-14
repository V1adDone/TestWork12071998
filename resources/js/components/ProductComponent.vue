<template>
    <tr class="product">
        <td>
            <span>{{ product.id }}</span>
        </td>
        <td>
            <input type="text" class="form-control" v-model="product.title">
        </td>
        <td>
            <input type="text" class="form-control" v-model="product.price">
        </td>
        <td>
            <button class="btn btn-dark" @click="update">Update</button>
            <button class="btn btn-danger" @click="del">Delete</button>
        </td>
    </tr>
</template>

<script>

    export default {
        methods: {
            del() {
                this.$emit('delete', this.id);
            },
            update() {
                this.$emit('update', this.product.id, this.product.title, this.product.price);
            }
        },
        props: ['id', 'title', 'price'],
        data() {
            return {
                product: {
                    id: this.id,
                    title: this.title,
                    price: this.price
                }
            }
        }
    }
</script>
