<script setup>
import {computed, onMounted, ref} from 'vue'
import {useI18n} from "vue-i18n";
import {v4 as uuidv4} from "uuid";

const {locale,t} = useI18n();

const props = defineProps({
    flag: {
        type: Boolean,
        required: true,
        default: false,
    },
    editData: {
        type: Object,
        required: false,
        default: null
    }
});

const {flag, editData} = props;

onMounted(() => {
    if (flag) {
        form.value = editData;
    }
})

let form = ref({
    id: '',
    label_name: '',
    visit_url: 'https://google.com',
    // tab/new
    open_mode: 'tab',
    adaptive_layout: true,
    width: 1920,
    height: 1080,
    sort: 0,
})

const ruleFormRef = ref(null)
const rules = computed(() => ({
    label_name: [
        {required: true, message: t('required_message'), trigger: 'blur'},
    ],
    visit_url: [
        {required: true, message: t('required_message'), trigger: 'blur'},
    ],
    open_mode: [
        {required: true, message: t('required_message'), trigger: 'blur'},
    ],
    adaptive_layout: [
        {required: form.open_mode === 'tab', message: t('required_message'), trigger: 'blur'},
    ],
    width: [
        {required: !form.adaptive_layout, message: t('required_message'), trigger: 'blur'},
    ],
    height: [
        {required: !form.adaptive_layout, message: t('required_message'), trigger: 'blur'},
    ],
    sort: [
        {required: true, message: t('required_message'), trigger: 'blur'},
    ],
}));

const submitForm = (callback) => {
    ruleFormRef.value.validate((valid, fields) => {
        if (valid) {
            if (!flag) {
                form.value.id = uuidv4().replaceAll("-", "")
            }
            callback(form.value);
        } else {
            console.log('error submit!', fields)
        }
    })
}
defineExpose({
    submitForm
});
</script>

<template>
    <div class="demo-collapse">
        <el-form ref="ruleFormRef" :rules="rules" :model="form" label-width="auto" style="max-width: 600px">
            <el-form-item :label="$t('label_name')" prop="label_name">
                <el-input v-model="form.label_name"/>
            </el-form-item>
            <el-form-item :label="$t('visit_url')" prop="visit_url">
                <el-input v-model="form.visit_url"/>
            </el-form-item>
            <el-form-item :label="$t('open_mode')" prop="open_mode">
                <el-radio-group v-model="form.open_mode">
                    <el-radio value="tab">tab</el-radio>
                    <el-radio value="new">new</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="$t('adaptive_layout')" v-if="form.open_mode == 'tab'" prop="adaptive_layout">
                <el-switch v-if="form.open_mode == 'tab'" v-model="form.adaptive_layout"/>
            </el-form-item>
            <el-form-item :label="$t('width')" v-if="!form.adaptive_layout && form.open_mode=='tab'" prop="width">
                <el-input-number v-if="!form.adaptive_layout && form.open_mode=='tab'" v-model="form.width"/>
            </el-form-item>
            <el-form-item :label="$t('height')" v-if="!form.adaptive_layout && form.open_mode=='tab'" prop="height">
                <el-input-number v-if="!form.adaptive_layout && form.open_mode=='tab'" v-model="form.height"/>
            </el-form-item>
            <el-form-item :label="$t('sort')" prop="sort">
                <el-input-number v-model="form.sort"/>
            </el-form-item>
        </el-form>
    </div>
</template>

<style scoped>
</style>
<style>
.el-input-number {
    width: 100%;
    border: none;
}

.el-input__inner {
    border: none !important;
}
</style>
