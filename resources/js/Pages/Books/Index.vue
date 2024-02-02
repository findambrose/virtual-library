<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Books">
        <Modal
            v-model="modal"
            title="Create Book"
            :ok-text="'Submit'"
            :loading="loading"
            @on-ok="submitForm">
            <Form>
                <FormItem label="Name">
                    <Input type="text" v-model="form.name" placeholder="Enter book name">
                    </Input>
                </FormItem>
                <FormItem label="ISBN">
                    <Input type="number" v-model="form.isbn" placeholder="Enter book ISBN">
                    </Input>
                </FormItem>
                <FormItem label="Choose Author">
                    <Select placeholder="Choose Author" v-model="form.author_id">
                        <Option v-for="item in authors" :value="item.id" :key="item.id">{{ item.name }}</Option>
                    </Select>
                </FormItem>
            </Form>
        </Modal>

        <Modal
            v-model="viewModal"
            title="Books Details"
            :ok-text="'Okay'"
            @on-ok="">
            <div>
                <p>Book Name: {{ book.name }}</p>
                <p>Book ISBN: {{ book.isbn }}</p>
                <p>Book Author: {{ book.author ? book.author.name : "-" }}</p>
            </div>
        </Modal>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Books
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-end mt-4 px-4 pb-4">
                        <Button @click="modal=true" type="primary">Create Book</Button>
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

export default {
    components: {
        AppLayout
    },
    props: {
        books: {
            type: Object,
            required: true
        },
        authors: {
            type: Object,
            required: true
        }
    },
    created: function () {
        this.data = this.books.data;
    },
    data() {
        return {
            form: {
                name: '',
                isbn: '',
                author_id: '',
            },
            book: {},
            modal: false,
            viewModal: false,
            loading: false,
            columns: [
                {
                    title: 'Name',
                    key: 'name'
                },
                {
                    title: 'ISBN',
                    key: 'isbn'
                },
                {
                    title: 'Author',
                    render: (h, params) => {
                        return h('span', params.row.author.name)
                    }
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
        }
    },
    methods: {
        submitForm() {
            this.loading = true;
            axios.post('api/books', this.form)
                .then(response => {
                    this.loading = false;
                    this.modal = false;
                    this.data = response.data.books.data;
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                })
        },
        getDetails(row) {
            axios.get('api/books/'+row.id)
                .then(response => {
                    this.book = response.data;
                    this.viewModal = true;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

