<template>
    <div class="gameboard__container">
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(0)" round>
                    {{ button0 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(1)" round>
                    {{ button1 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(2)" round>
                    {{ button2 }}
                </ElButton>
            </ElCol>
        </ElRow>
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(3)" round>
                    {{ button3 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(4)" round>
                    {{ button4 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(5)" round>
                    {{ button5 }}
                </ElButton>
            </ElCol>
        </ElRow>
        <ElRow :gutter="20">
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(6)" round>
                    {{ button6 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(7)" round>
                    {{ button7 }}
                </ElButton>
            </ElCol>
            <ElCol :span="6">
                <ElButton class="gameboard__gamebutton" type="info" @click="onButtonPressed(8)" round>
                    {{ button8 }}
                </ElButton>
            </ElCol>
        </ElRow>
    </div>
</template>

<script lang="ts" setup>
import type { ElButton } from 'element-plus';

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

function onButtonPressed(index: Number) {
    let response = gameService.makeStep(index)
    updateButtons()
}

function updateButtons() {

}
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