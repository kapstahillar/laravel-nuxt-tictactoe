<template>
    <div v-if="playerInAGame" class="gamecontainer__stateholder current"> Your turn </div>
    <GameBoard :gameSession="currentGame" v-if="playerInAGame" class="gamecontainer__gameboard" />
    <ElRow>
        <ElButton v-if="playerInAGame" @click="quitGame" type="danger"> Quit </ElButton>
        <ElButton v-else type="success" @click="startNewGame"> Start </ElButton>
    </ElRow>
</template>

<script lang="ts" setup>

import type GameSession from '~/api/models/Gamesession';

const currentGame = ref(null as GameSession | null)
const playerInAGame = ref(false)
const { gameService } = useApi()
const emit = defineEmits(['onNewGameStarted'])

async function checkForAGame() {
    const game = await gameService.getCurrentGame()
    if (Object.keys(game).length !== 0) {
        playerInAGame.value = true
        currentGame.value = game
    }
}

async function startNewGame() {
    const game = await gameService.startGame()
    playerInAGame.value = true
    currentGame.value = game
    emit('onNewGameStarted', game)
}

async function quitGame() {
    await gameService.quitCurrentGame()
    playerInAGame.value = false
    currentGame.value = null
}

onMounted(() => {
    checkForAGame()
})
</script>

<style scoped>
.gamecontainer__gameboard {
    margin: 40px 0;
}

.gamecontainer__stateholder {
    color: orange;
}

.gamecontainer__stateholder.current {
    color: green;
}
</style>