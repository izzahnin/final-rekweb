<template>
<main class="w-4/5 flex flex-col justify-center my-6 m-auto ">
    <div class="mb-4">
      <button @click="showAddModal" class="bg-blue-500 text-white px-4 py-2 rounded">
        Tambah Buku
      </button>
    </div>

    <div v-if="books.length === 0" class="text-gray-500">Tidak ada buku yang tersedia.</div>

    <ul v-else v-for="book in books" :key="book.id" class="border p-4 mb-4">
      <li class="mb-2"><strong>Judul:</strong> {{ book.title }}</li>
      <li class="mb-2"><strong>Penulis:</strong> {{ book.author }}</li>
      <li class="mb-2"><strong>Deskripsi:</strong> {{ book.description }}</li>
      <li class="mb-2"><strong>ISBN:</strong> {{ book.isbn }}</li>
      <div class="flex space-x-2">
        <button @click="showEditModal(book)" class="bg-yellow-500 text-white px-2 py-1 rounded">
          Edit
        </button>
        <button @click="deleteBook(book.id)" class="bg-red-500 text-white px-2 py-1 rounded">
          Hapus
        </button>
      </div>
    </ul>

    <!-- Add/Edit Modal -->
    <section v-if="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-8 rounded shadow w-96">
        <h2 class="text-2xl mb-4">{{ modalTitle }}</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input v-model="form.title" type="text" class="mt-1 p-2 w-full border rounded">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Penulis</label>
            <input v-model="form.author" type="text" class="mt-1 p-2 w-full border rounded">
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea v-model="form.description" class="mt-1 p-2 w-full border rounded"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">ISBN</label>
            <input v-model="form.isbn" type="text" class="mt-1 p-2 w-full border rounded">
          </div>
          <div class="flex justify-end">
            <button type="button" @click="hideModal" class="mr-2 bg-gray-300 px-4 py-2 rounded">Batal</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ modalAction }}</button>
          </div>
        </form>
      </div>
    </section>
  </main>
</template>


<script setup>
  const { books } = defineProps(["books"]);

  import axios from 'axios';
  import { ref } from 'vue';

const showModal = ref(false);
const modalTitle = ref('');
const modalAction = ref('');
const form = ref({
  id: null,
  title: '',
  author: '',
  description: '',
  isbn: ''
});

const showAddModal = () => {
  showModal.value = true;
  modalTitle.value = 'Tambah Buku';
  modalAction.value = 'Tambah';
  resetForm();
};

const showEditModal = (book) => {
  showModal.value = true;
  modalTitle.value = 'Edit Buku';
  modalAction.value = 'Simpan';
  form.value = { ...book };
};

const hideModal = () => {
  showModal.value = false;
  resetForm();
};

const submitForm = () => {
  console.log('Form Data:', form.value);
  hideModal();
};


const deleteBook = (id) => {
  const confirmDelete = window.confirm('Are you sure you want to delete this book?');

  if (confirmDelete) {
    axios.delete(`/books/${id}`)
      .then(() => {
        console.log('Book deleted successfully');
        Inertia.reload();
      })
      .catch((error) => {
        console.error('Error deleting book:', error);
      });
  }
};

const resetForm = () => {
  form.value = {
    id: null,
    title: '',
    author: '',
    description: '',
    isbn: ''
  };
};
</script>