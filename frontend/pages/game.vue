<template>
    <ElContainer class="game__container">
        <ElHeader class="game__header">
            <ElRow>
                <ElCol :span="2" :offset="4">
                    <ElButton type="info" class="game__logout-button" @click="submitLogout">Logout</ElButton>
                </ElCol>
            </ElRow>
        </ElHeader>
        <ElContainer>
            <ElAside class="game__sidebar">
                <GamesList class="game__gamelist" :games="games" ref="listRef" />
            </ElAside>
            <ElMain>
                <GameContainer class="game__game-container" @onGameFinished="onGameFinished"
                    @onNewGameStarted="onNewGameStarted" />
            </ElMain>
        </ElContainer>
    </ElContainer>
</template>

<script lang="ts" setup>
import { ElCol } from 'element-plus';
import type GameSession from '~/api/models/Gamesession';
import '~/assets/css/main.css'
import GamesList from '~/components/game/GamesList.vue';

definePageMeta({
    middleware: ["auth"],
});

const { logout } = useAuth();
const router = useRouter();
const config = useRuntimeConfig();
const listRef: Ref<typeof GamesList | null> = ref(null);
const { gameService } = useApi()
const games = ref(await gameService.getAllGames())

function onNewGameStarted(game: GameSession) {
    games.value.unshift(game)
}

function onGameFinished(game: GameSession) {
    games.value.shift()
    games.value.unshift(game)
    console.log(games)
}

async function submitLogout() {
    await logout();
    router.push(config.public.loginUrl);
}

</script>
<style scoped>
.game__header {
    background-color: #439775;
}

.game__logout-button {
    width: 100%;
    margin-top: 12px;
    margin-right: 10px;
}

.game__game-container {
    margin-left: auto;
    margin-right: auto;
}

.game__sidebar {
    background-color: #48BF84;
}

.game__gamelist {}
</style>