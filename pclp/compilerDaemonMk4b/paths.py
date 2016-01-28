#!/usr/bin/python
# -*- coding: utf-8 -*-
import os

rootCompilerPath = os.path.abspath(os.path.join(os.path.dirname( __file__ ), '..')) + '/'
inputPath = rootCompilerPath + 'outputcase/hasil'

# outputPath adalah tempat executable diletakan

outputPath = rootCompilerPath + 'result/'

# sourcePath adalah tempat hasil upload source code peserta

sourcePath = rootCompilerPath + 'upload/'

# testPath adalah tempat file berisi input ditempatkan
# testCase adalah nama depan dari file berisi input

testPath = rootCompilerPath + 'inputcase/testCase'

# tmpPath adalah tempat untuk menampung output dari program peserta

tmpPath = '/tmp'

# limiterPath adalah tempat berisi data limitasi waktu(untuk saat ini)

limiterPath = rootCompilerPath + 'limiter/limit'

# memoryPath adalah tempat file berisi batasan memory yang diijinkan

memoryPath = rootCompilerPath + 'memory/memory'

# statusPath adalah tempat file status diletakan

statusPath = rootCompilerPath + 'status/'

# tollerance path

tollerancepath = rootCompilerPath + 'tollerance/toll'
