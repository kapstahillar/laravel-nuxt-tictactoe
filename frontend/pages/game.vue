<template>
    <div class="common-layout">
        <ElContainer>
            <ElHeader class="game__header">
                <ElRow>
                    <ElCol :span="6">
                        <h2> Tic Tac Toe </h2>
                    </ElCol>
                    <ElCol :span="2" :offset="16">
                        <ElButton type="info" @click="submitLogout">Logout</ElButton>
                    </ElCol>
                </ElRow>
            </ElHeader>
            <ElContainer>
                <ElAside>
                    <GamesList :games="games" ref="listRef" />
                </ElAside>
                <ElMain class="game__container">
                    <GameContainer @onNewGameStarted="onNewGameStarted" />
                </ElMain>
            </ElContainer>
        </ElContainer>
    </div>
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
    games.value.push(game)
}

async function submitLogout() {
    await logout();
    router.push(config.public.loginUrl);
}

</script>
<style scoped></style>