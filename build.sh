#!/bin/bash
chmod 0755 -R ./src
#获取当前目录
BUILD_LINK="$(readlink -f .)"
#插件名称
PLUGIN_NAME=taglib
#版本号
VERSION=$(date +"%Y.%m.%d")
mkdir "releases"
cd ./src
makepkg -l y -c y ../releases/${PLUGIN_NAME}-${VERSION}.txz
txzMd5="$(md5sum ../releases/${PLUGIN_NAME}-${VERSION}.txz | awk '{print $1}')"
echo "md5sum:$txzMd5"

cd ../
sed -i 's/<!ENTITY md5.*/<!ENTITY md5       "'"$txzMd5"'">/' ./plugins/taglib.plg
git add .
git commit -m "${PLUGIN_NAME}-${VERSION}.txz"
git push
