<template>
    <AuthenticatedLayout>
        <Head title="Chat" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="font-bold text-xl mb-4 p-3">Messages</div>
                    <hr/>
                    <div class="overflow-y-auto max-h">
                        <ul class="chat list-none p-6">
                            <li v-for="(message, i) in msg" :key="i" class="left clearfix">
                                <div class="clearfix">
                                    <div class="header">
                                        <strong class="text-blue-500">
                                         {{ message.user.name }}:
                                        </strong>
                                        {{ message.message }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="mt-4 p-4">
                        <div class="flex items-center">
                            <input
                                id="btn-input"
                                type="text"
                                name="message"
                                class="border border-gray-200 rounded w-full"
                                placeholder="Type your message here..."
                                v-model="form.message"
                                @keyup.enter="submit"
                            />
                            <span class="ml-2">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded" id="btn-chat" @click="submit">
                                    Send
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from "@inertiajs/vue3"
import axios from 'axios'
import { ref, onMounted } from "vue"

onMounted(()=>{
    axios.get('/messages').then(response => {
        msg.value = response.data
    })

    window.Echo.channel('chat').listen('MessageNotification', (response) => {
        console.log(response);
        msg.value.push({
            message: response.message.message,
            user: response.user
        });
         alert('Show without refresh!')
    });
})

const msg = ref([]);
const form = useForm({
    message: ""
})

const submit = () => {
    axios.post("/chat", form).then((response)=> {
        msg.value = response.data
        form.message = null
    })
}
</script>
