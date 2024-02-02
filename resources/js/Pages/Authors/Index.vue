<template>
    <AppLayout title="Authors">
        <Modal
            v-model="modal"
            title="Create Author"
            :ok-text="'Submit'"
            :cancel-text="'Cancel'"
            :loading="loading"
            @on-ok="submitForm">
            <Form >
                <FormItem label="Name">
                    <Input type="text" v-model="form.name" placeholder="Enter full name">
                    </Input>
                </FormItem>
                <FormItem label="Age">
                    <Input type="number" v-model="form.age" placeholder="Enter Age">
                    </Input>
                </FormItem>
                <div class="grid grid-cols-2 gap-2">
                    <FormItem label="Gender">
                        <Select placeholder="Choose Gender" v-model="form.gender">
                            <Option v-for="item in genders" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </FormItem>
                    <FormItem label="Country">
                        <Select placeholder="Choose Country" v-model="form.country">
                            <Option v-for="item in countries" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </FormItem>
                </div>
                <FormItem label="Books' Genre">
                    <Input type="text" v-model="form.genre" placeholder="Enter Books' Genre">
                    </Input>
                </FormItem>

            </Form>
        </Modal>
        <Modal
            v-model="viewModal"
            title="Author Details"
            :ok-text="'Okay'"
            @on-ok="">
            <div>
                <p>Author Name: {{ author.name }}</p>
                <p>Age: {{ author.age }}</p>
                <p>Country: {{ author.country }}</p>
                <p>Gender: {{ author.gender }}</p>
                <p>Genre: {{ author.genre }}</p>
            </div>
        </Modal>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Authors
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end mt-4 px-4 pb-4">
                        <Button @click="modal=true" type="primary">Create Author</Button>
                    </div>
                    <Table :no-data-text="'No data'" :columns="columns" :data="data">
                        <template #action="{ row, index }">
                            <Button type="primary" size="small" style="margin-right: 5px" @click="getDetails(row)">View Details</Button>
                        </template>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Table} from "view-ui-plus";
import {Button, Modal} from "view-ui-plus";

export default {
    components: {
        Table,
        AppLayout,
        Button,
        Modal
    },
    props: {
        authors: {
            type: Object,
            required: true
        }
    },
    created: function () {
        this.data = this.authors.data;
    },
    data() {
        return {
            form: {
                name: '',
                gender: '',
                age: '',
                country: '',
                genre: '',
            },
            author: {},
            countries: [
                {
                    value: 'Kenya',
                    label: 'Kenya'
                },
                {
                    value: 'Uganda',
                    label: 'Uganda'
                },
                {
                    value: 'Tanzania',
                    label: 'Tanzania'
                },
                {
                    value: 'Cambodia',
                    label: 'Cambodia'
                }
            ],
            genders: [
                {
                    value: 'Male',
                    label: 'Male'
                },
                {
                    value: 'Female',
                    label: 'Female'
                }
            ],
            modal: false,
            viewModal: false,
            loading: false,
            columns: [
                {
                    title: 'Name',
                    key: 'name'
                },
                {
                    title: 'Gender',
                    key: 'gender'
                },
                {
                    title: 'Age',
                    key: 'age'
                },
                {
                    title: 'Country',
                    key: 'country'
                },
                {
                    title: 'Genre',
                    key: 'genre'
                },
                {
                    title: 'Created At',
                    key: 'created_at'
                },
                {
                    title: 'Actions',
                    slot: 'action'
                }
            ],
            data: [

            ]
        }
    },
    methods: {
        submitForm() {
            this.loading = true;
            axios.post('api/authors', this.form)
                .then(response => {
                    this.loading = false;
                    this.modal = false;
                    this.data = response.data.authors.data;
                    this.$swal('Success', 'Author created successfully', 'success');
                })
                .catch(error => {
                    this.loading = false;
                    this.$swal('Error', 'An error occurred', 'error');
                    console.log(error);
                })
        },
        getDetails(row) {
            axios.get('api/authors/'+row.id)
                .then(response => {
                    this.author = response.data;
                    this.viewModal = true;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>
