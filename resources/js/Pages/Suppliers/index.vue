<template>
    <AppLayout title="Supplier Management">
        <template #header>
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body row">
                        <div class="col-lg-8 align-items-center py-4">
                            <h6 class="h2 text-dark d-inline-block mb-0">Suppliers Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-block ">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item">
                                        <Link href="/">
                                        <font-awesome-icon icon="fa-solid fa-house" color="#505050" />
                                        </Link>
                                    </li>
                                    <li class="breadcrumb-item active breadcrumb-yellow" aria-current="page">
                                        Suppliers Management
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-4 text-right py-4">
                            <a href="javascript:void(0)" @click.prevent="newSupplier"
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
                                            <th :class="textClassHead">Email</th>
                                            <th :class="textClassHead">Contact No</th>
                                            <th :class="textClassHead">Web</th>
                                            <th :class="textClassHead">Status</th>
                                            <th :class="textClassHead"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="supplier in suppliers" :key="supplier.id" :class="rowClass">
                                            <td :class="textClassBody">
                                                {{ supplier.name }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ supplier.email }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ supplier.contact_no }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ supplier.web_url }}
                                            </td>
                                            <td :class="textClassBody">
                                                {{ supplier.status }}
                                            </td>
                                            <td class="text-right">
                                                <a href="javascript:void(0)" @click.prevent="editSupplier(supplier.id)"
                                                    class="p-2 float-end">
                                                    <font-awesome-icon icon="fa-solid fa-pen" class="text-ash text-right" />
                                                </a>
                                                <a href="javascript:void(0)" @click.prevent="deleteSupplier(supplier.id)"
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
            <div class="modal fade" id="newSupplierModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="newSupplierModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-mb" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-yellow text-gradient" id="add_brandLabel">
                                New Supplier</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="fa fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="card-plain">
                                <div class="card-body">
                                    <form role="form text-left" @submit.prevent="createSupplier"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label">
                                                NAME
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="supplier.name" placeholder="Name" required />
                                            </div>
                                            <small v-if="validationErrors.name" id="msg_name"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.name
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="email" class="col-md-3 col-form-label">
                                                EMAIL
                                            </div>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control form-control-sm" name="email"
                                                    id="email" v-model="supplier.email" placeholder="Email" />
                                            </div>
                                            <small v-if="validationErrors.email" id="msg_email"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.email
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="contact" class="col-md-3 col-form-label">
                                                CONTACT
                                            </div>
                                            <div class="col-md-9">
                                                <input type="tel" class="form-control form-control-sm" name="contact_no"
                                                    id="contact_no" v-model="supplier.contact_no" placeholder="Contact No"
                                                     />
                                            </div>
                                            <small v-if="validationErrors.contact_no" id="msg_contact_no"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.contact_no
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="web_url" class="col-md-3 col-form-label">
                                                WEB URL
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="web_url"
                                                    id="web_url" v-model="supplier.web_url" placeholder="Web URL" />
                                            </div>
                                            <small v-if="validationErrors.web_url" id="msg_web_url"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.web_url
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
            <div class="modal fade" id="editSupplierModal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="editSupplierModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bolder breadcrumb-yellow text-gradient title_modal"
                                id="add_brandLabel">
                                Edit Supplier</h5>
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <font-awesome-icon icon="fa-solid fa-xmark" />
                                </span>
                            </button>
                        </div>
                        <div class="modal-body p-2">
                            <div class="card card-plain">
                                <div class="card-body">
                                    <form role="form text-left" @submit.prevent="updateSupplier"
                                        enctype="multipart/form-data">
                                        <div class="row mb-1">
                                            <div for="name" class="col-md-3 col-form-label ">NAME</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="name"
                                                    id="name" v-model="edit_supplier.name" placeholder="Name" required>
                                                <small v-if="validationErrors.name" id="msg_name"
                                                    class="text-danger form-text text-error-msg error">{{
                                                        validationErrors.name }}</small>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="email" class="col-md-3 col-form-label">EMAIL</div>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control form-control-sm" name="email"
                                                    id="email" v-model="edit_supplier.email" placeholder="Email" />
                                            </div>
                                            <small v-if="validationErrors.email" id="msg_email"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.email
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="contact_no" class="col-md-3 col-form-label">CONTACT</div>
                                            <div class="col-md-9">
                                                <input type="tel" class="form-control form-control-sm" name="contact_no"
                                                    id="contact_no" v-model="edit_supplier.contact_no" placeholder="Contact"
                                                     />
                                            </div>
                                            <small v-if="validationErrors.contact_no" id="msg_contact_no"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.contact_no
                                                }}</small>
                                        </div>
                                        <div class="row mb-1">
                                            <div for="web_url" class="col-md-3 col-form-label">
                                                WEB URL
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control form-control-sm" name="web_url"
                                                    id="web_url" v-model="edit_supplier.web_url" placeholder="Web URL" />
                                            </div>
                                            <small v-if="validationErrors.web_url" id="msg_web_url"
                                                class="text-danger form-text text-error-msg error">{{
                                                    validationErrors.web_url
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
            perPage: [10,25, 50, 100],
            pageCount: 10,
            pagination: {},

            supplier: {},
            suppliers: [],
            edit_supplier: {},

            search_supplier: {},

        };
    },
    beforeMount() {
        library.add(faHouse);
        library.add(faFloppyDisk);
        library.add(faCirclePlus);
        library.add(faPen);
        library.add(faTrash);
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
                await axios.get(route("suppliers.all"), {
                    params: {
                        page: this.page,
                        per_page: this.pageCount,
                        "filter[search]": this.search,
                    },
                })
            ).data;

            this.suppliers = tableData.data;
            this.pagination = tableData.meta;
        },
        async getSuppliers() {
            const suppliers = (await axios.get(route("suppliers.all"))).data;
            this.suppliers = suppliers.data;
            this.pagination = suppliers.meta;
        },
        async createSupplier() {
            this.resetValidationErrors();
            try {
                const supplier = (await axios.post(route("suppliers.store"), this.supplier)).data;
                $("#newSupplierModal").modal("hide");
                this.supplier = {};
                this.reload();
                Swal.fire({
                    title: "Success",
                    text: "Supplier created successfully",
                    icon: "success",
                    confirmButtonColor: "#6CA925",
                });
            } catch (error) {
                this.convertValidationError(error);
            }
        },
        async editSupplier(id) {
            this.resetValidationErrors();
            try {
                const supplier = (await axios.get(route('suppliers.get', id))).data
                this.edit_supplier = supplier.data
                $('#editSupplierModal').modal('show')
            } catch (error) {
                this.convertValidationError(error)
            }
        },
        async updateSupplier() {
            this.resetValidationErrors();
            try {
                await axios.post(route('suppliers.update', this.edit_supplier.id), this.edit_supplier);
                this.reload();
                $('#editSupplierModal').modal('hide')
                this.edit_supplier = {}
                Swal.fire({
                    title: 'Success',
                    text: 'Supplier updated successfully',
                    icon: 'success',
                    confirmButtonColor: '#6CA925',
                })
            } catch (error) {
                this.convertValidationError(error)
            }
        },
        async newSupplier() {
            this.supplier = {};
            $("#newSupplierModal").modal("show");
        },
        async deleteSupplier(id) {
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
                        axios.delete(route('suppliers.delete', id)).then((response) => {
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
