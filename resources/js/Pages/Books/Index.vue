<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <Modal
            v-model="modal"
            title="Create Author"
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
                    <Select v-model="form.author_id">
                        <Option v-for="item in authors" :value="item.id" :key="item.id">{{ item.name }}</Option>
                    </Select>
                </FormItem>
            </Form>
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
                    <Table :columns="columns" :data="books.data"></Table>
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
    data() {
        return {
            form: {
                name: '',
                isbn: '',
                author_id: '',
            },
            modal: false,
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
                    key: 'author'
                },
                {
                    title: 'Created At',
                    key: 'created_at'
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
                    this.$emit('authorCreated', response.data);
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                })
        }
    }
}
</script>

