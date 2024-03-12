<template>
    <ElRow>
        <ElButton v-if="playerInAGame" @click="quitGame" type="danger"> Quit </ElButton>
        <ElButton v-if="!playerInAGame && !loading" type="success" @click="startNewGame"> Start </ElButton>
    </ElRow>
    <GameBoard @onGameFinished="onGameFinished" :gameSession="currentGame" v-if="playerInAGame"
        class="gamecontainer__gameboard" />
</template>

<script lang="ts" setup>

import type GameSession from '~/api/models/Gamesession';

const currentGame = ref(null as GameSession | null)
const playerInAGame = ref(false)
const { gameService } = useApi()
const emit = defineEmits(['onNewGameStarted', 'onGameFinished'])
const loading = ref(true);

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

function onGameFinished(gameSession: GameSession) {
    playerInAGame.value = false
    currentGame.value = null
    emit('onGameFinished', gameSession)
}

async function quitGame() {
    await gameService.quitCurrentGame()
    playerInAGame.value = false
    currentGame.value = null
}

onMounted(() => {
    checkForAGame()
    loading.value = false
})
</script>

<style scoped>
.gamecontainer__gameboard {
    margin: 40px auto;
}
</style>