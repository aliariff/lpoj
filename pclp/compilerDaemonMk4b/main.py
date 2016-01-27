#!/usr/bin/python
# -*- coding: utf-8 -*-

from Compiler import *
from updater import Updater
import os
import _mysql
import re
import sys
import fnmatch
import paths


def strip(path):
    file = open(path, 'r')
    for line in file:
        d = re.search('system', line)
        if d:
            return True

    return False


if len(sys.argv) > 1:
    if sys.argv[1] == 'update':
        updater = Updater()
        updater.update()
        print 'updated'
        exit()
    elif sys.argv[1] == 'help':
        print 'this program is used as command line tool to control pclp compiler daemon'
        print 'Usage'
        print 'main.py help   show this message and exit'
        print 'main.py update update the file used as a test case and comparator, please run this parameter'
        print '               before you run the daemon'
        print 'main.py        run the daemon'
        exit()
    else:
        print 'unknown argument(s)'

while 1 == 1:
    list1 = os.listdir(paths.rootCompilerPath + 'upload/')
    pat = re.compile('index.html')
    for i in list1:
        if i[0] == '.':
            continue
        if pat.search(i) != None:
            continue
        comp = Compiler(paths.rootCompilerPath + 'upload/' + i)
        if strip(paths.rootCompilerPath + 'upload/' + i):
            comp.malcode()
        else:
            comp.compile()
            g = comp.test()
            os.system('mkdir ' + paths.rootCompilerPath + 'backup/'
                      + comp.soal)
        os.system('mv ' + paths.rootCompilerPath + 'upload/' + i + ' '
                  + paths.rootCompilerPath + 'backup/' + comp.soal + '/'
                  )
        if comp.compiled != 1:
            continue
        os.system('rm ' + comp.outputPath + '*')
