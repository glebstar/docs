<template>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>File</th>
            <th>Action</th>
        </tr>
        <tr v-for="{ id, name, description, file} in documents">
            <td>{{ name }}</td>
            <td>{{ description }}</td>
            <td v-if="file"><img :src="'/storage/' + file.path" class="img-thumbnail" style="width: 200px;"></td>
            <td v-else></td>
            <td><router-link :to="{ name: 'documents.edit', params: { id } }"><i class="fa fa-edit"></i></router-link> </td>
        </tr>
    </table>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                documents: null,
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.documents = null;
                axios
                    .get('/api/documents')
                    .then(response => {
                        this.documents = response.data.data;
                    });
            }
        }
    }

</script>
