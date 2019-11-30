<template>
    <div>
        <h1>Create a Document</h1>
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
                <label for="document_file">File</label>
                <input type="file" id="document_file" ref="myFile" v-on:change="previewFile()">
            </div>
            <div class="form-group">
                <button type="submit" :disabled="saving">
                    {{ saving ? 'Creating...' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';


    export default {
        data() {
            return {
                saving: false,
                message: false,
                document: {
                    name: '',
                    description: '',
                    file: null,
                }
            }
        },
        methods: {
            onSubmit($event) {
                this.saving = true;
                this.message = false;
                let formdata = new FormData();
                formdata.append('name', this.document.name);
                formdata.append('description', this.document.description);
                formdata.append('file', this.document.file);
                axios.post('/api/documents', formdata, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then((response) => {
                        this.$router.push({ name: 'documents.edit', params: { id: response.data.data.id } });
                    })
                    .catch((e) => {
                        console.log(e.response);
                        this.message = e.response.data.message || 'There was an issue creating the document.';
                    })
                    .then(() => this.saving = false)
            },
            previewFile() {
                this.document.file = this.$refs.myFile.files[0];
            },
        },
    }
</script>
