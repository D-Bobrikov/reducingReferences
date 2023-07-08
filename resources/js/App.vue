<template>
    <div class="col-5 container text-center">
        <h1>Сократите свою ссылку</h1>
        <table v-if="links.total" class="table">
            <thead>
            <tr>
                <th scope="col">URL</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="link in links.data" :key="link.id">
                <td><a v-bind:href="link.full_reference">http://{{ link.short_reference }}</a></td>
                <td>
                    <button @click="deleteLink(link.id)" type="button" class="btn btn-danger">Удалить</button>
                </td>
            </tr>
            </tbody>
        </table>
        <p v-else>Ещё нет сокращённых ссылок</p>

        <form>
            <div class="mb-3">
                <input class="form-control" placeholder="Введите url ссылки" v-model="fullLink">
            </div>
            <button type="submit" :class="addDisabledClass" class="btn btn-info" @click="postLink(fullLink)">Сократить</button>
        </form>

        <div v-if="links.total > 10 " class="d-flex justify-content-evenly">
            <p><a @click="prevPageUrl" href="#" class="link-underline-dark">Назад</a></p>
            <p><a @click="nextPageUrl" href="#" class="link-underline-dark">Вперёд</a></p>
        </div>
        <p>Cтраница: {{ links.current_page }}</p>
        <p>Всего записей: {{ links.total }}</p>
    </div>
</template>

<script>

import { deleteLink, getLinks, postLink, prevPageUrl, nextPageUrl } from '../js/api.js'

export default {
  data () {
    return {
      links: [],
      errors: [],
      fullLink: '',
      deleteLink,
      getLinks,
      postLink,
      prevPageUrl,
      nextPageUrl
    }
  },

  created () {
    this.getLinks()
  },

  computed: {
    // eslint-disable-next-line vue/return-in-computed-property
    addDisabledClass () {
      if (!this.fullLink) {
        return 'disabled'
      }
    }
  }
}
</script>
