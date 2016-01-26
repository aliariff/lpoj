#!/usr/bin/python
# -*- coding: utf-8 -*-

from Compiler import *
import os
import _mysql
import re


def strip(path):
    file = open(path, 'r')
    for line in file:
        d = re.search('system', line)
        if d:
            return True

    return False


list1 = os.listdir('/root/pclp/upload/')
for i in list1:
    if i[0] == '.':
        continue
    comp = Compiler('/root/pclp/upload/' + i)
    if strip('/root/pclp/upload/' + i):
        comp.malcode()
    else:
        comp.compile()
        comp.test()

    # os.system("mv /root/pclp/upload/"+i+" /root/pclp/backup/"+i)

    if comp.compiled != 1:
        continue
    os.system('rm ' + comp.outputPath + '*')
