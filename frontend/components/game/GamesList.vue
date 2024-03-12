<template>
    <ul class="gameslist__list" style="overflow: auto">
        <li v-if="props.games.length > 0" v-for="gameSession in props.games">
            <ElCard class="gameslist__item-card" :class="getWinnerClass(gameSession.winner)">
                <span v-if="gameSession.completed_at != null">
                    {{ $dayjs(gameSession.completed_at).format('DD/MM/YYYY HH:mm') }}
                </span>
                <span v-else>Game is currently still on</span>
            </ElCard>
        </li>
        <span v-else>There are no current games</span>
    </ul>
</template>
<script lang="ts" setup>
import type GameSession from '~/api/models/Gamesession';


const props = defineProps({
    games: {
        type: Array as PropType<GameSession[]>,
        default: () => []
    }
})

function getWinnerClass(value: number | null) {
    if (null === value) {
        return "winner-none"
    } else if (value === 1) {
        return "winner-opponent"
    } else {
        return "winner-player"
    }
}

</script>
<style scoped>
.gameslist__list {
    padding-left: 20px;
}

.gameslist__list li {
    list-style: none;
}

.gameslist__item-card.winner-player {
    background-color: green;
}

.gameslist__item-card.winner-opponent {
    background-color: orangered;
}

.gameslist__item-card.winner-none {
    background-color: yellow;
}
</style>