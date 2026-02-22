<template>
    <div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    Avatar
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                    Nickname
                </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <tr
                v-for="user in users"
                :key="user.nickname"
                class="hover:bg-gray-50"
            >
                <td class="px-6 py-4">
                    <img
                        :src="user.avatar"
                        :alt="user.nickname"
                        class="w-12 h-12 rounded-full object-cover"
                    />
                </td>

                <td class="px-6 py-4 text-gray-800 font-medium">
                    {{ user.nickname }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps({
    users: {
        type: Array,
        required: true,
    },
})
</script>
