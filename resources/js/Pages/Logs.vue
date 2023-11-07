<template>
    <div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UserID</th>
                    <th>Ação</th>
                    <th>Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="log in parsedLogs" :key="log.id">
                    <td>{{ log.id }}</td>
                    <td>{{ log.user_id }}</td>
                    <td>{{ log.action }}</td>
                    <td>{{ log.name }}</td>
                    <td>{{ formatDate(log.created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="text" spellcheck="true">
</template>
  
<script setup>
import { computed } from 'vue'

const props = defineProps({
    logs: Array
});

const parsedLogs = computed(() => {
    return props.logs.map(log => {
        const data = JSON.parse(log.data);
        return {
            id: log.id,
            user_id: log.user_id,
            action: log.action,
            name: data.name,
            created_at: log.created_at
        };
    });
});

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};
</script>
  