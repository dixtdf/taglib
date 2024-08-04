<script setup>
import {ref} from 'vue'
import {useI18n} from "vue-i18n";
import axios from "axios";
import ini from "ini";
import AddEditView from "./AddEditView.vue";

const {locale} = useI18n();

const changeLocale = (lang) => {
  locale.value = lang;
};

getLocale();
init();

function getLocale() {
  let settingUrl = "/plugins/taglib/include/setting.php";
  const params = new URLSearchParams()
  params.append('action', "getLocale")
  params.append('csrf_token', window.csrf_token)
  axios({
    method: "post",
    url: settingUrl,
    headers: {
      "accept": "*/*",
      "Content-Type": "application/x-www-form-urlencoded;charset=utf-8"
    },
    data: params,
  }).then(res => {
    try {
      if (res.data) {
        const config = ini.parse(res.data);
        const locale = config.display.locale;
        changeLocale(locale)
      } else {
        changeLocale('')
      }
    } catch (e) {
      changeLocale('')
    }
  }).catch(error => {
    changeLocale('')
  });
}

let tableData = ref([
  {
    label_name: '2016-05-03',
    visit_url: 'Tom',
    open_mode: 'California',
    adaptive_layout: 'Los Angeles',
    width: 'No. 189, Grove St, Los Angeles',
    height: 'CA 90036',
    sort: 'Home',
  },
]);

function init() {
  let settingUrl = "/plugins/taglib/include/setting.php";
  const params = new URLSearchParams()
  params.append('action', "getData")
  params.append('csrf_token', window.csrf_token)
  axios({
    method: "post",
    url: settingUrl,
    headers: {
      "accept": "*/*",
      "Content-Type": "application/x-www-form-urlencoded;charset=utf-8"
    },
    data: params,
  }).then(res => {
    tableData.value = res.data;
  });
}

const addEditView = ref(null);
let flag = ref(false);

function edit() {
  flag.value = true;
  if (addEditView.value) {
    addEditView.value.openView();
  }
}

//
// let tabData = [];
//
// function applyData(settings) {
//   $.post(settingUrl, {action: 'applyData', settings: JSON.stringify(settings)}, (data) => {
//     if (data) {
//       location.reload();
//     }
//   });
// }
//
// function toggleInput() {
//   let table = document.getElementById('addTag');
//   let width = table.querySelector('input[name="width"]');
//   let height = table.querySelector('input[name="height"]');
//   let adaptive = table.querySelector('input[name="adaptive"]:checked').value;
//   if (adaptive == 'true') {
//     width.disabled = true;
//     height.disabled = true;
//   } else {
//     width.disabled = false;
//     height.disabled = false;
//   }
// }
//

//
// function addRow() {
//   let table = document.getElementById('addTag');
//   let label = table.querySelector('input[name="label"]').value;
//   let address = table.querySelector('input[name="address"]').value;
//   let open = table.querySelector('select[name="open"]').value;
//   let adaptive = table.querySelector('input[name="adaptive"]:checked').value;
//   let width = table.querySelector('input[name="width"]').value;
//   let height = table.querySelector('input[name="height"]').value;
//   let sort = table.querySelector('input[name="sort"]').value;
//
//   if (!label) {
//     alert("请检查标签名称是否填写");
//     return;
//   }
//   if (!/^[A-Za-z].*$/.test(label)) {
//     alert("标签名称必须以英文开头");
//     return;
//   }
//   if (!address) {
//     alert("请检查地址是否填写");
//     return;
//   }
//   if (!open) {
//     alert("请检查打开方式是否选中");
//     return;
//   }
//   if (!adaptive) {
//     alert("请检查是否自适应是否选中");
//     return;
//   }
//   if (!width) {
//     alert("请检查宽度是否填写");
//     return;
//   }
//   if (!height) {
//     alert("请检查高度是否填写");
//     return;
//   }
//   if (!sort) {
//     alert("请检查排序是否填写");
//     return;
//   }
//   debugger
//   if (!tabData) {
//     tabData = [];
//   }
//   tabData.push({
//     "label": label,
//     "address": address,
//     "open": open,
//     "adaptive": adaptive,
//     "width": width,
//     "height": height,
//     "sort": sort
//   });
//
//   table.querySelector('input[name="label"]').value = "";
//   table.querySelector('input[name="address"]').value = "";
//   table.querySelector('select[name="open"]').value = "tab";
//   table.querySelector('input[name="width"]').value = "1920px";
//   table.querySelector('input[name="height"]').value = "1080px";
//   table.querySelector('input[name="sort"]').value = "0";
//
//   applyData(tabData);
// }
//
// function delRow(index) {
//   tabData.splice(index, 1);
//   applyData(tabData);
// }
//
// $(function () {
//   init();
// });
</script>

<template>
  <AddEditView ref="addEditView" :flag="flag"/>
  <div style="padding: 0px 10px">
    <el-table border :data="tableData" style="width: 100%">
      <el-table-column prop="label_name" :label="$t('label_name')" width="120"/>
      <el-table-column prop="visit_url" :label="$t('visit_url')"/>
      <el-table-column prop="open_mode" :label="$t('open_mode')" width="120"/>
      <el-table-column prop="adaptive_layout" :label="$t('adaptive_layout')" width="120"/>
      <el-table-column prop="width" :label="$t('width')" width="120"/>
      <el-table-column prop="height" :label="$t('height')" width="120"/>
      <el-table-column prop="sort" :label="$t('sort')" width="120"/>
      <el-table-column fixed="right" :label="$t('operation')">
        <template #default>
          <el-button link type="primary" size="small" @click="edit">{{ $t('edit') }}</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<style scoped lang="css">
.read-the-docs {
  color: #888;
}

:deep(table) {
  margin: 0;
}

</style>
<style>
.el-table th.el-table__cell {
  background-color: transparent;
}

.el-table.is-scrolling-none th.el-table-fixed-column--left, .el-table.is-scrolling-none th.el-table-fixed-column--right {
  background-color: transparent;
}

.el-table tr {
  background-color: transparent;
}
</style>
