<template>
    <div class="gameboard__container">
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(0)"
                    round>
                    {{ button0 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(1)"
                    round>
                    {{ button1 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(2)"
                    round>
                    {{ button2 }}
                </ElButton>
            </ElCol>
        </ElRow>
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(3)"
                    round>
                    {{ button3 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(4)"
                    round>
                    {{ button4 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(5)"
                    round>
                    {{ button5 }}
                </ElButton>
            </ElCol>
        </ElRow>
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(6)"
                    round>
                    {{ button6 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(7)"
                    round>
                    {{ button7 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton :disabled=makingAMove class="gameboard__gamebutton" type="info" @click="onButtonPressed(8)"
                    round>
                    {{ button8 }}
                </ElButton>
            </ElCol>
        </ElRow>
    </div>
</template>

<script lang="ts" setup>
import type { ElButton } from 'element-plus';
import type GameSession from '~/api/models/Gamesession';

const { gameService } = useApi()

const button0 = ref<string>(" ")
const button1 = ref<string>(" ")
const button2 = ref<string>(" ")
const button3 = ref<string>(" ")
const button4 = ref<string>(" ")
const button5 = ref<string>(" ")
const button6 = ref<string>(" ")
const button7 = ref<string>(" ")
const button8 = ref<string>(" ")
const arrayOfButtons = [button0, button1, button2, button3, button4, button5, button6, button7, button8]

const props = defineProps({
    gameSession: {
        type: Object as PropType<GameSession | null>,
        required: true
    }
})
const emit = defineEmits(['onGameFinished'])
const makingAMove = ref(false)

async function onButtonPressed(index: number) {
    makingAMove.value = true
    let response = await gameService.makeStep(index)
    response.state.split("-").forEach((item: string, key: number) => {
        arrayOfButtons[key].value = item
    });
    if (response.winner !== null) {
        finishGame(response)
    } else {
        makingAMove.value = false
    }
}

function finishGame(gameSession: GameSession) {

    if (gameSession.winner === null) {
        ElNotification({
            title: 'Tie',
            message: 'Game has ended in a tie',
            type: 'info',
        })
    } else if (gameSession.winner === 1) {
        ElNotification({
            title: 'Lost',
            message: 'Ai has bested you!',
            type: 'error',
        })
    } else {
        ElNotification({
            title: 'Winner',
            message: 'You have won!',
            type: 'success',
        })
    }

    setTimeout(() => {
        makingAMove.value = false
        emit('onGameFinished', gameSession.winner)
    }, 1000)
}

onMounted(() => {
    props.gameSession?.state.split("-").forEach((item: string, key: number) => {
        arrayOfButtons[key].value = item
    });
})
</script>

<style scoped>
.gameboard__container {
    max-width: 600px;
}

.el-row {
    margin-bottom: 20px;
}

.el-row:last-child {
    margin-bottom: 0;
}

.gameboard__gamebutton {
    padding: 40px;
    height: 100px;
    width: 100px;
}
</style>