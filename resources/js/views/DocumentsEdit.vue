<template>
    <div>
        <h1>Edit a Document</h1>
        <div v-if="message" class="alert alert-danger">{{ message }}</div>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group">
                <label for="document_name">Name</label>
                <input id="document_name" class="form-control" v-model="document.name">
            </div>
            <div class="form-group">
                <label for="document_description">Description</label>
                <textarea class="form-control" id="document_description" v-model="document.description"></textarea>
            </div>
            <div class="form-group">
                <img v-if="document.file" :src="'/storage/' + document.file.path" class="img-thumbnail" style="width: 200px;">
                <label for="document_file">File</label>
                <input type="file" id="document_file" ref="myFile" v-on:change="previewFile()">
            </div>
            <div class="form-group">
                <button type="submit" :disabled="saving">
                    {{ saving ? 'Updating...' : 'Update' }}
                </button>
                <button :disabled="saving" @click.prevent="onDelete($event)">Delete</button>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return {
                saving: false,
                message: false,
                document: {
                    id: null,
                    name: '',
                    description: '',
                    file: null,
                }
            }
        },
        created() {
            axios.get(`/api/documents/${this.$route.params.id}`)
                .then((response) => {
                    this.document = response.data.data;
                })
                .catch((err) => {
                    this.$router.push({ name: '404' });
                });
        },
        methods: {
            onSubmit(event) {
                this.saving = true;

                let formdata = new FormData();
                formdata.append('name', this.document.name);
                formdata.append('description', this.document.description);
                formdata.append('file', this.document.file);
                formdata.append('_method', 'PUT');

                axios.post(`/api/documents/${this.document.id}`, formdata, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then((response) => {
                    this.message = 'Document updated';
                    setTimeout(() => this.message = null, 2000);
                    this.document = response.data.data;
                }).catch((e) => {
                    this.message = e.response.data.message || 'There was an issue creating the document.';
                }).then(_ => this.saving = false);
            },
            onDelete() {
                this.saving = true;
                axios.delete(`/api/documents/${this.document.id}`)
                    .then((response) => {
                        this.message = 'Document Deleted';
                        setTimeout(() => this.$router.push({ name: 'home' }), 2000);
                    });
            },
            previewFile() {
                this.document.file = this.$refs.myFile.files[0];
            },
        },
    }
</script>
