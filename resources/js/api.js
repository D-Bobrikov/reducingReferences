import axios from 'axios'

export async function deleteLink (id) {
  await axios.delete(import.meta.env.VITE_APP_URL + '/api/link/' + id).then()
  await this.getLinks()
}

export async function getLinks () {
  axios
    .get(import.meta.env.VITE_APP_URL + '/api/link')
    .then((response) => {
      this.links = response.data
    })
    .catch((e) => {
      this.errors.push(e)
    })
}

export async function postLink (fullLink) {
  axios
    .post(import.meta.env.VITE_APP_URL + '/api/link', {
      link: fullLink
    })
    .then((response) => {
    })
    .catch((e) => {
      this.errors.push(e)
    })
  await this.getLinks()
  this.fullLink = ''
}

export async function nextPageUrl () {
  axios
    .get(this.links.next_page_url)
    .then((response) => {
      this.links = response.data
    })
    .catch((e) => {
      this.errors.push(e)
    })
}

export async function prevPageUrl () {
  axios
    .get(this.links.prev_page_url)
    .then((response) => {
      this.links = response.data
    })
    .catch((e) => {
      this.errors.push(e)
    })
}
