<template>
    <div class="col-5 container text-center">
        <h1>Сократи свою ссылку</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">URL</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="link in links.data">
                <td><a v-bind:href="link.full_reference">http://{{ link.short_reference }}</a></td>
                <td>
                    <button @click="deleteLink(link.id)" type="button" class="btn btn-danger">Удалить</button>
                </td>
            </tr>
            </tbody>
        </table>

        <form>
            <div class="mb-3">
                <input class="form-control" placeholder="Введите url ссылки" v-model="fullLink">
            </div>
            <button type="submit" class="btn btn-primary" @click="postLink(fullLink)">Сократить</button>
        </form>

        <div class="d-flex justify-content-evenly">
            <p><a @click="prevPageUrl" href="#" class="link-underline-dark">Назад</a></p>
            <p><a @click="nextPageUrl" href="#" class="link-underline-dark">Вперёд</a></p>
        </div>
        <p>Cтраница: {{ links.current_page }}</p>
        <p>Всего записей: {{ links.total }}</p>
    </div>
</template>

<script>

import axios from 'axios'

export default {
    data: () => ({
        links: [],
        errors: [],
        fullLink: ''
    }),

    async created () {
        await this.getLinks()
    },

    methods: {
        getLinks () {
            axios.get('http://127.0.0.1:8000/api/link')
                .then(response => {
                    this.links = response.data
                }).catch(e => {
                this.errors.push(e)
            })
        },

        postLink (fullLink) {
            axios.post('http://127.0.0.1:8000/api/link', {
                link: fullLink
            })
                .then(response => {
                })
                .catch(e => {
                    this.errors.push(e)
                })
            this.getLinks()
            this.fullLink = ''
        },

        nextPageUrl () {
            axios.get(this.links.next_page_url)
                .then(response => {
                    this.links = response.data
                }).catch(e => {
                this.errors.push(e)
            })
        },

        prevPageUrl () {
            axios.get(this.links.prev_page_url)
                .then(response => {
                    this.links = response.data
                }).catch(e => {
                this.errors.push(e)
            })
        },

        deleteLink (id) {
            axios.delete('http://127.0.0.1:8000/api/link/' + id).then()
            this.getLinks()
        }
    }
}
</script>

