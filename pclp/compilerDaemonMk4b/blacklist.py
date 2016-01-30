#!/usr/bin/python
# -*- coding: utf-8 -*-
import re

def check(path):
  blacklist = ['system', '`', '%60', 'eval', 'fork', 'spawn', 'exec', 'syscall']
  file = open(path, 'r')
  for line in file:
    for cmd in blacklist:
      if re.search(cmd, line):
        return True
  return False
