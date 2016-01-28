#!/usr/bin/python
# -*- coding: utf-8 -*-
import re


def strip(path):
    file = open(path, 'r')
    for line in file:
        d = re.search('system', line)
        backtick = re.search('`', line)
        if d or backtick:
            return True

    return False
