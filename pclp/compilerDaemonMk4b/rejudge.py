#!/usr/bin/python
# -*- coding: utf-8 -*-

from Compiler import *
from updater import Updater
import os
import _mysql
import re
import sys
import paths


def strip(path):
    file = open(path, 'r')
    for line in file:
        d = re.search('system', line)
        backtick = re.search('`', line)
        if d or backtick:
            return True

    return False


while 1 == 1:
    list1 = os.listdir(paths.rootCompilerPath + 'backup/')
    for i in list1:
        name = i.split('.')
        if name[0] == 'rejudge':
            os.system('rm ' + paths.rootCompilerPath + 'backup/' + i)
            list1 = sorted(os.listdir(paths.rootCompilerPath + 'backup/'
                            + name[1] + '/'))
            for i in list1:
                print i
                if i[0] == '.':
                    continue
                comp = Compiler(paths.rootCompilerPath + 'backup/'
                                + name[1] + '/' + i)
                if strip(paths.rootCompilerPath + 'backup/' + name[1]
                         + '/' + i):
                    comp.malcode()
                else:
                    comp.compile()
                    g = comp.test()
                if comp.compiled != 1:
                    continue
                os.system('rm ' + comp.outputPath + '*')
