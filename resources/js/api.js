import axios from 'axios'

export async function deleteLink (id) {
  await axios.delete('http://127.0.0.1:8000/api/link/' + id).then()
  await this.getLinks()
}

export async function getLinks () {
  axios.get('http://127.0.0.1:8000/api/link')
    .then(response => {
      this.links = response.data
    }).catch(e => {
      this.errors.push(e)
    })
}

export async function postLink (fullLink) {
  axios.post('http://127.0.0.1:8000/api/link', {
    link: fullLink
  })
    .then(response => {
    })
    .catch(e => {
      this.errors.push(e)
    })
  await this.getLinks()
  this.fullLink = ''
}

export async function nextPageUrl () {
  axios.get(this.links.next_page_url)
    .then(response => {
      this.links = response.data
    }).catch(e => {
      this.errors.push(e)
    })
}

export async function prevPageUrl () {
  axios.get(this.links.prev_page_url)
    .then(response => {
      this.links = response.data
    }).catch(e => {
      this.errors.push(e)
    })
}
