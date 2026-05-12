<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'

interface FamilyMember {
  id?: number
  first_name: string
  last_name: string
  maiden_name?: string
  gender: 'male' | 'female' | 'other' | ''
  birth_date?: string
  birth_place?: string
  death_date?: string
  death_place?: string
  nationality?: string
  occupation?: string
  bio?: string
}

const familyMembers = ref<FamilyMember[]>([])
const loading = ref(true)
const showModal = ref(false)
const editingMember = ref<FamilyMember | null>(null)
const form = ref<FamilyMember>({
  first_name: '',
  last_name: '',
  maiden_name: '',
  gender: '',
  birth_date: '',
  birth_place: '',
  death_date: '',
  death_place: '',
  nationality: '',
  occupation: '',
  bio: '',
})

const fetchFamilyMembers = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/family-members')
    familyMembers.value = response.data.data
  } catch (error) {
    console.error('Hiba a családtagok lekérésekor:', error)
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  editingMember.value = null
  form.value = {
    first_name: '',
    last_name: '',
    maiden_name: '',
    gender: '',
    birth_date: '',
    birth_place: '',
    death_date: '',
    death_place: '',
    nationality: '',
    occupation: '',
    bio: '',
  }
  showModal.value = true
}

const openEditModal = (member: FamilyMember) => {
  editingMember.value = member
  form.value = {
    ...member,
    birth_date: member.birth_date ? member.birth_date.substring(0, 10) : '',
    death_date: member.death_date ? member.death_date.substring(0, 10) : '',
  }
  showModal.value = true
}

const saveMember = async () => {
  try {
    if (editingMember.value) {
      await axios.put(`/api/family-members/${editingMember.value.id}`, form.value)
    } else {
      await axios.post('/api/family-members', form.value)
    }
    showModal.value = false
    fetchFamilyMembers()
  } catch (error) {
    console.error('Hiba a mentéskor:', error)
    alert('Hiba történt a mentés során.')
  }
}

const deleteMember = async (id: number) => {
  if (!confirm('Biztosan törölni szeretné ezt a családtagot?')) return

  try {
    await axios.delete(`/api/family-members/${id}`)
    fetchFamilyMembers()
  } catch (error) {
    console.error('Hiba a törléskor:', error)
    alert('Hiba történt a törlés során.')
  }
}

onMounted(() => {
  fetchFamilyMembers()
})

const formatDate = (dateString?: string) => {
  if (!dateString) return '-'
  try {
    return new Date(dateString).toLocaleDateString('hu-HU')
  } catch (e) {
    return dateString
  }
}
</script>

<template>
  <div class="p-6 text-gray-900">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold">Családtagjaim</h2>
      <button
        @click="openCreateModal"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      >
        Új családtag hozzáadása
      </button>
    </div>

    <div v-if="loading" class="text-center py-4">
      <p class="text-gray-500">Betöltés...</p>
    </div>

    <div v-else-if="familyMembers.length === 0" class="text-gray-500 italic">
      Még nincsenek felvéve családtagok.
    </div>

    <div v-else class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Név</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nem</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Születési dátum</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Születési hely</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Műveletek</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="member in familyMembers" :key="member.id">
            <td class="px-6 py-4 whitespace-nowrap">
              {{ member.last_name }} {{ member.first_name }}
              <span v-if="member.maiden_name" class="text-gray-400 text-sm">({{ member.maiden_name }})</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span v-if="member.gender === 'male'">Férfi</span>
              <span v-else-if="member.gender === 'female'">Nő</span>
              <span v-else-if="member.gender === 'other'">Egyéb</span>
              <span v-else>-</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ formatDate(member.birth_date) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              {{ member.birth_place ?? '-' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <button @click="openEditModal(member)" class="text-indigo-600 hover:text-indigo-900 mr-3">Szerkesztés</button>
              <button @click="deleteMember(member.id!)" class="text-red-600 hover:text-red-900">Törlés</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <form @submit.prevent="saveMember">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                {{ editingMember ? 'Családtag szerkesztése' : 'Új családtag hozzáadása' }}
              </h3>

              <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Vezetéknév</label>
                  <input v-model="form.last_name" type="text" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Keresztnév</label>
                  <input v-model="form.first_name" type="text" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Leánykori név</label>
                <input v-model="form.maiden_name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nem</label>
                <select v-model="form.gender" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  <option value="">Válasszon...</option>
                  <option value="male">Férfi</option>
                  <option value="female">Nő</option>
                  <option value="other">Egyéb</option>
                </select>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Születési dátum</label>
                  <input v-model="form.birth_date" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Születési hely</label>
                  <input v-model="form.birth_place" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Életrajz</label>
                <textarea v-model="form.bio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                Mentés
              </button>
              <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Mégse
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
