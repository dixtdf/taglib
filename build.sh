#!/bin/bash
chmod 0755 -R ./src
#获取当前目录
BUILD_LINK="$(readlink -f .)"
#插件名称
PLUGIN_NAME=Taglib
#版本号
VERSION=$(date +"%Y.%m.%d")
mkdir "releases"
cd ./src
makepkg -l y -c y ../releases/${PLUGIN_NAME}-${VERSION}.txz
echo "md5sum:"
md5sum ../releases/${PLUGIN_NAME}-${VERSION}.txz
