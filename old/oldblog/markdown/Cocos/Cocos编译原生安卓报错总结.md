# Cocos踩坑指南

1. 编译报错,卡在cpufeatures <= cpu-features.c而导致failed
   - 原因是 cocos发布路径设置太长导致windows无法创建文件,
   - 把工程挪到如D盘的根目录,并设置发布路径到如D盘根目录即可
   - 不要把工程放到桌面!桌面的C盘路径也长!

```shell
C:/Users/Administrator/AppData/Local/Android/Sdk/ndk/21.0.6113669/build//../toolchains/llvm/prebuilt/windows-x86_64/bin/arm-linux-androideabi-ar: C:/Users/Administrator/Desktop/weiduomu/weiduomu/build/jsb-link/frameworks/runtime-src/proj.android-studio/app/build/intermediates/ndkBuild/release/obj/local/armeabi-v7a/objs/cocos2dx_static/scripting/js-bindings/jswrapper/v8/debugger/inspector_socket_server.o: No such file or directory
make: *** [C:/Users/Administrator/AppData/Local/Android/Sdk/ndk/21.0.6113669/build//../build/core/build-binary.mk:600: C:/Users/Administrator/Desktop/weiduomu/weiduomu/build/jsb-link/frameworks/runtime-src/proj.android-studio/app/build/intermediates/ndkBuild/release/obj/local/armeabi-v7a/libcocos2d.a] Error 1
[armeabi-v7a] StaticLibrary : libcocos2d.a
make: *** Waiting for unfinished jobs....
[armeabi-v7a] Compile thumb : cpufeatures <= cpu-features.c
[armeabi-v7a] StaticLibrary : libextension.a
[armeabi-v7a] Compile++ thumb: cocos2dxandroid_static <= CCCanvasRenderingContext2D-android.cpp
Try:
Run with --stacktrace option to get the stack trace. Run with --debug option to get more log output. Run with --scan to get full insights.
Get more help at https://help.gradle.org
BUILD FAILED50 actionable tasks: 3 executed, 47 up-to-date
in 6m 12s
执行命令出错，返回值：1
```