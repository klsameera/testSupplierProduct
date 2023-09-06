<template>
    <AppLayout title="product Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body row">
                        <div class="col-lg-8 align-items-center py-4">
                            <h6 class="h2 text-dark d-inline-block mb-0">Products Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block ">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <Link href="/">
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active breadcrumb-yellow" aria-current="page">
                                        Products Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-4 text-right py-4">
                            <a href="javascript:void(0)" @click.prevent="newProduct"
                                class="btn btn-sm btn-neutral float-end">
                                <font-awesome-icon icon="fa-solid fa-circle-plus" /> ADD NEW
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #content>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="pb-3 filters-margin mx-3 text-sm card-body">
                            <div class="flex">
                                <div class="flex items-center text-muted">
                                    <div class="mt-2">
                                        Search:
                                    </div>
                                    <div class="inline-block ml-2">
                                        <input type="text" class="form-control form-control-sm" v-model="search"
                                            @keyup="getSearch" />
                                    </div>
                                </div>
                                <div class="flex text-muted ml-auto">
                                    <div class="inline-block">
                                        <select class="form-control form-control-sm per-page-entry" :value="25"
                                            v-model="pageCount" @change="perPageChange">
                                            <option v-for="perPageCount in perPage" :key="perPageCount"
                                                :value="perPageCount" v-text="perPageCount" />
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th :class="textClassHead">Name</th>
                                            <th :class="textClassHead">Code</th>
                                            <th :class="textClassHead">Image</th>
                                            <th :class="textClassHead">Price</th>
                                            <th :class="textClassHead">Quantity</th>
                                            <th :class="textClassHead">Status</th>
                                            <th :class="textClassHead"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products" :key="product.id" :class="rowClass">
                                            <td :class="textClassBody">
                                                {{ product.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ product.code }}
                                            </td>
                                            <td :class="textClassBody">
                                                <img :src="product.image_url" alt="" style="width: 30px;">
                                            </td>
                                            <td :class="textClassBody">
                                                {{ product.price }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ product.quantity }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ product.status }}
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" @click.prevent="editProduct(product.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash text-right" />
                                                </a>
                                                <a href="javascript:void(0)" @click.prevent="deleteproduct(product.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-trash"
                                                        class="text-ash text-right" />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex mt-1 px-3 mx-1 card-footer table-footer align-items-center">
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_info column__left___padding" id="DataTables_Table_0_info"
                                    role="status" aria-live="polite">
                                    Showing {{ pagination.from }} to
                                    {{ pagination.to }} of
                                    {{ pagination.total }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 p-0">
                                <div class="dataTables_paginate paging_simple_numbers column__right___padding"
                                    id="DataTables_Table_0_paginate">
                                    <nav aria-label="Page navigation" style="float: right">
                                        <ul class="pagination">
                                            <li class="page-item" :class="pagination.current_page == 1 ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page - 1)">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                            <template v-for="(page, index) in pagination.last_page">
                                                <template
                                                    v-if="page == 1 || page == pagination.last_page || Math.abs(page - pagination.current_page) < 5">
                                                    <li class="page-item" :key="index"
                                                        :class="pagination.current_page == page ? 'active' : ''">
                                                        <a class="page-link" @click="setPage(page)">{{ page }}</a>
                                                    </li>
                                                </template>
                                            </template>
                                            <li class="page-item"
                                                :class="pagination.current_page == pagination.last_page ? 'disabled' : ''">
                                                <a class="page-link" href="javascript:void(0)"
                                                    @click="setPage(pagination.current_page + 1)">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modals>
            <div class="modal fade" id="newProductModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newProductModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-mb" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-yellow text-gradient" id="add_brandLabel">
                                New product</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="fa fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body">
                                    <form role="form text-left" @submit.prevent="createProduct"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="product.name" placeholder="Name" required />
                                            </div>
                                            <small v-if="validationErrors.name" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.name
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="code" class="col-md-3 col-form-label">
                                                CODE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="product.code" placeholder="Code" />
                                            </div>
                                            <small v-if="validationErrors.email" id="msg_email"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.email
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="image" class="col-md-3 col-form-label">
                                                IMAGE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="file" ref="file" class="form-control form-control-sm"
                                                    @input="product.photo = $event.target.files[0]" />
                                            </div>
                                            <small v-if="validationErrors.photo" id="msg_photo"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.photo
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="description" class="col-md-3 col-form-label">
                                                Description
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="description" id="" cols="30" rows="5"
                                                    v-model="product.description"
                                                    class="form-control form-control-sm"></textarea>
                                            </div>
                                            <small v-if="validationErrors.description" id="description"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.description
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="price" class="col-md-3 col-form-label">
                                                UNIT PRICE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control form-control-sm" name="price"
                                                    step="any" id="price" v-model="product.price"
                                                    placeholder="Unit Price" />
                                            </div>
                                            <small v-if="validationErrors.price" id="msg_price"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.price
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="quantity" class="col-md-3 col-form-label">
                                                Quantity
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control form-control-sm" name="quantity"
                                                    step="any" id="quantity" v-model="product.quantity"
                                                    placeholder="Quantity" />
                                            </div>
                                            <small v-if="validationErrors.quantity" id="msg_quantity"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.quantity
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="quantity" class="col-md-3 col-form-label">
                                                Supplier
                                            </div>
                                            <div class="col-md-9">
                                                <select name="supplier_id" id="supplier_id"
                                                    class="form-control form-control-sm" v-model="product.supplier_id">
                                                    <option v-for="supplier in suppliers" :key="supplier.id"
                                                        :value="supplier.id" v-text="supplier.name"></option>
                                                </select>
                                            </div>
                                            <small v-if="validationErrors.quantity" id="msg_quantity"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.quantity
                                                }}</small>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="submit" class="btn btn-round btn-outline-primary btn-sm mb-0">
                                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                                CREATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editProductModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editProductModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-yellow text-gradient title_modal"
                                id="add_brandLabel">
                                Edit product</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-2">
                            <div class="card card-plain">
                                <div class="card-body">
                                    <form role="form text-left" @submit.prevent="updateProduct"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label ">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_product.name" placeholder="Name" required>
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="email" class="col-md-3 col-form-label">CODE</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="code"
                                                    id="code" v-model="edit_product.code" placeholder="Code" />
                                            </div>
                                            <small v-if="validationErrors.code" id="msg_code"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.code
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="image" class="col-md-3 col-form-label">
                                                IMAGE
                                            </div>
                                            <div class="col-md-9">
                                                <div class="upload-img mb-3" v-if="edit_product.image">
                                                    <img :src="edit_product.image_url" alt="" width="300">
                                                </div>
                                                <input type="file" ref="file_update" class="form-control form-control-sm"
                                                    @input="edit_product.photo = $event.target.files[0]" />
                                            </div>
                                            <small v-if="validationErrors.photo" id="msg_photo"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.photo
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="description" class="col-md-3 col-form-label">
                                                Description
                                            </div>
                                            <div class="col-md-9">
                                                <textarea name="description" id="" cols="30" rows="5"
                                                    v-model="edit_product.description"
                                                    class="form-control form-control-sm"></textarea>
                                            </div>
                                            <small v-if="validationErrors.description" id="description"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.description
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="price" class="col-md-3 col-form-label">
                                                UNIT PRICE
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control form-control-sm" name="price"
                                                    step="any" id="price" v-model="edit_product.price"
                                                    placeholder="Unit Price" />
                                            </div>
                                            <small v-if="validationErrors.price" id="msg_price"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.price
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="quantity" class="col-md-3 col-form-label">
                                                Quantity
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control form-control-sm" name="quantity"
                                                    step="any" id="quantity" v-model="edit_product.quantity"
                                                    placeholder="Quantity" />
                                            </div>
                                            <small v-if="validationErrors.quantity" id="msg_quantity"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.quantity
                                                }}</small>
                                        </div>
                                        <div class="text-right mt-2">
                                            <button type="submit" class="btn  btn-round btn-outline-primary btn-sm mb-0">
                                                <font-awesome-icon icon="fa-solid fa-floppy-disk" />
                                                UPDATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Swal from "sweetalert2";


import { library } from '@fortawesome/fontawesome-svg-core';
import { faHouse, faFloppyDisk, faCirclePlus, faPen, faTrash } from '@fortawesome/free-solid-svg-icons';

export default {
    components: {
        AppLayout,
        Link,
        library,
    },
    data() {
        return {
            textClassBody: "text-start",
            iconClassHead: "text-center",
            iconClassBody: "text-center",
            rowClass: "cursor-pointer",

            search: null,
            page: 1,
            perPage: [10, 25, 50, 100],
            pageCount: 10,
            pagination: {},

            product: {},
            suppliers: [],
            products: [],
            edit_product: {},

            search_product: {},
        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faFloppyDisk);
        library.add(faCirclePlus);
        library.add(faPen);
        library.add(faTrash);
        this.getProducts();
        this.getSuppliers();
    },
    watch: {

    },
    methods: {
        async setPage(page) {
            this.page = page;
            this.reload();
        },
        async getSearch() {
            this.page = 1;
            this.reload();
        },
        async perPageChange() {
            this.reload();
        },
        async reload() {
            const tableData = (
                await axios.get(route("products.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.products = tableData.data;
            this.pagination = tableData.meta;
        },
        async getProducts() {
            const products = (await axios.get(route("products.all"))).data;
            this.products = products.data;
            this.pagination = products.meta;
        },
        async getSuppliers() {
            const suppliers = (await axios.get(route("suppliers.all.dropdown"))).data;
            this.suppliers = suppliers.data;
        },
        async createProduct() {
            this.resetValidationErrors();
            try {
                const file = this.$refs.file.files[0];
                if (file) {
                    if (file.size > 5000000) {
                        Swal.fire({
                            title: "Error",
                            text: "File size must be less than 5MB",
                            icon: "error",
                            confirmButtonColor: "#6CA925",
                        });
                        return;
                    }
                }
                const product = (await axios.post(route("products.store"), this.product,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })).data;
                $("#newProductModal").modal("hide");
                this.product = {};
                this.reload();
                Swal.fire({
                    title: "Success",
                    text: "product created successfully",
                    icon: "success",
                    confirmButtonColor: "#6CA925",
                });
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async editProduct(id) {
            this.resetValidationErrors();
            try {

                const product = (await axios.get(route('products.get', id))).data
                this.edit_product = product.data
                $('#editProductModal').modal('show')
            } catch (error) {
                this.convertValidationError(error)
            }
        },
        async updateProduct() {
            this.resetValidationErrors();
            try {
                const file = this.$refs.file_update.files[0];
                if (file) {
                    if (file.size > 5000000) {
                        Swal.fire({
                            title: "Error",
                            text: "File size must be less than 5MB",
                            icon: "error",
                            confirmButtonColor: "#6CA925",
                        });
                        return;
                    }
                }
                await axios.post(route('products.update', this.edit_product.id), this.edit_product, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                this.reload();
                $('#editProductModal').modal('hide')
                this.edit_product = {}
                Swal.fire({
                    title: 'Success',
                    text: 'product updated successfully',
                    icon: 'success',
                    confirmButtonColor: '#6CA925',
                })
            } catch (error) {
                this.convertValidationError(error)
            }
        },
        async newProduct() {
            this.product = {};
            $("#newProductModal").modal("show");
        },
        async deleteproduct(id) {
            try {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#C00202', // Green
                    cancelButtonColor: '#6CA925', // Secondary Color
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(route('products.delete', id)).then((response) => {
                            this.reload();
                        });

                    }
                })
            } catch (error) {
                this.convertValidationNotification(error)
            }
        },
    },
}
</script>
<style lang="scss" scoped>
.breadcrumb-yellow {
    color: #f29b29 !important;
}

.filters-margin {
    margin-top: 0.7rem !important;
}
</style>
