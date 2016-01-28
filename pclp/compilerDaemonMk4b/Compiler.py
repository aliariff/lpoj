#!/usr/bin/python
# -*- coding: utf-8 -*-

import os
import signal
import _mysql
import paths
import database
import MySQLdb
import sys
from sandbox import *
import time


class Compiler:

    log = 'compiler.log'

    def __init__(self, path):
        self.canonicalPath = path
        print path
        path2 = path.rsplit('/')
        self.filename = path2[len(path2) - 1]
        data = self.filename.split('_-_')
        print data
        self.hashcode = data[1]
        self.waktu = data[0]
        self.soal = data[2]
        self.user = data[3]
        self.filetype = data[4].rsplit('.')[1]
        self.filename = data[4].rsplit('.')[0]
        self.root = os.curdir

        self.inputPath = paths.inputPath

        self.outputPath = paths.outputPath

        self.sourcePath = paths.sourcePath

        self.testPath = paths.testPath

        self.tmpPath = paths.tmpPath
        self.compiled = 0
        self.total = 0
        self.ac_count = 0
        self.submit_log = ''
        self.status_log = '.1.'

        limiter = open(paths.limiterPath + self.soal, 'r')
        limit = limiter.readline()
        self.limit = float(limit)
        limiter.close()
        memoryL = open(paths.memoryPath + self.soal, 'r')
        self.memo = memoryL.readline()
        memoryL.close()

        self.db = MySQLdb.connect(host=database.host,
                                  user=database.user,
                                  passwd=database.passwd,
                                  db=database.dbname)

    def compile(self):
        if os.path.isfile(self.canonicalPath):
            if self.filetype == 'c':
                returnStat = os.system('gcc -o ' + self.outputPath
                        + 'out ' + self.canonicalPath + ' -lm')
                self.compiled = 1 - returnStat
            elif self.filetype == 'cpp':
                returnStat = os.system('g++ -o ' + self.outputPath
                        + 'out ' + self.canonicalPath)
                self.compiled = 1 - returnStat
            elif self.filetype == 'pas':
                print 'fpc ' + self.canonicalPath + ' -o' \
                    + self.outputPath + 'out'
                returnStat = os.system('fpc ' + self.canonicalPath
                        + ' -o' + self.outputPath + 'out')
                self.compiled = 1 - returnStat
            elif self.filetype == 'java':
                returnStat = os.system('javac -d ' + self.outputPath
                        + ' ' + self.canonicalPath + ' > '
                        + self.tmpPath + 'tmpLog')
                self.compiled = 1 - returnStat
            elif self.filetype == 'rb' or self.filetype == 'py':
                self.compiled = 1
            else:
                status = open(paths.rootCompilerPath + 'status/'
                              + self.waktu + '.' + self.hashcode
                              + '.0.10', 'w')
                status.close()

    def testRun(o):
        print o
        os.system(o)

    def malcode(self):
        logs = open(Compiler.log, 'a')
        logs.write('kompilasi ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' GAGAL, MALICIOUS CODE\n')
        logs.close()
        status = open(paths.rootCompilerPath + 'status/' + self.waktu
                      + '.' + self.hashcode + '.0.11.1', 'w')
        status.close()
        return

    def test(self):
        returnStat = 0
        if self.compiled != 1:
            self.ce()
            return
        else:
            counter = len([name for name in
                          os.listdir(paths.rootCompilerPath
                          + 'inputcase/') if self.soal in name])

            if self.filetype == 'java':
                os.chdir(self.outputPath)

                returnStat = os.system('java -Duser.language=EN '
                        + self.filename + '<' + self.testPath
                        + self.soal + '>' + self.tmpPath + '/tempOut &')

                time.sleep(float(self.limit))
                os.system('ps -C java -o pid= > pid')
                if os.path.getsize('./pid') != 0:
                    pid = open('./pid')
                    os.system('kill ' + pid.readline())
                    pid.close()
                    status = open(paths.rootCompilerPath + 'status/'
                                  + self.waktu + '.' + self.hashcode
                                  + '.0', 'w')
                    status.close()
                    return
            elif self.filetype == 'py':
                for i in range(1, counter + 1):
                    print 'i = ' + str(i)
                    returnStat = os.system('python '
                            + self.canonicalPath + '<' + self.testPath
                            + self.soal + '_' + str(i) + '>'
                            + self.tmpPath + '/tempOut &')
                    time.sleep(float(self.limit))
                    os.system('ps aux | grep ' + self.canonicalPath
                              + " | grep -v grep | awk '{print $2}' > pid"
                              )
                    if os.path.getsize('./pid') != 0:
                        pid = open('./pid')
                        proid = pid.readline()
                        proid = int(proid)
                        os.kill(proid, signal.SIGKILL)
                        pid.close()
                        self.tle(i)
                        continue
                    self.compare(i)
            elif self.filetype == 'rb':
                for i in range(1, counter + 1):
                    print 'i = ' + str(i)
                    returnStat = os.system('ruby ' + self.canonicalPath
                            + '<' + self.testPath + self.soal + '_'
                            + str(i) + '>' + self.tmpPath + '/tempOut &'
                            )
                    time.sleep(float(self.limit))
                    os.system('ps aux | grep ' + self.canonicalPath
                              + " | grep -v grep | awk '{print $2}' > pid"
                              )
                    if os.path.getsize('./pid') != 0:
                        pid = open('./pid')
                        proid = pid.readline()
                        proid = int(proid)
                        os.kill(proid, signal.SIGKILL)
                        pid.close()
                        self.tle(i)
                        continue
                    self.compare(i)
            elif self.filetype == 'cpp' or self.filetype == 'c':
                self.limit = self.limit * 1000
                for i in range(1, counter + 1):
                    print 'i = ' + str(i)
                    s = Sandbox(self.outputPath + 'out',
                                stdin=open(self.testPath + self.soal
                                + '_' + str(i), 'r'),
                                stdout=open(self.tmpPath + '/tempOut',
                                'w'), quota=dict(cpu=int(self.limit),
                                memory=int(self.memo),
                                wallclock=int(self.limit)))
                    s.run()
                    y = s.probe()
                    if s.result == 3:
                        self.mle(i)
                        continue
                    if s.result == 5:
                        self.tle(i)
                        continue
                    if s.result == 6:
                        self.rte(i)
                        continue
                    self.compare(i)

            if self.ac_count == counter:
                self.status_log = '.7.'
                self.total = 100
            status = open(paths.rootCompilerPath + 'status/'
                          + self.waktu + '.' + self.hashcode + '.'
                          + str(self.total) + self.status_log
                          + self.submit_log, 'w')
            status.close()
            logs = open(Compiler.log, 'a')
            logs.write('HASIL ' + str(self.hashcode) + ' '
                       + self.filename + '.' + self.filetype + ' '
                       + self.user + ' ' + self.soal + ' '
                       + str(self.total) + '\n')
            logs.close()
            print 'total = ' + str(self.total)

    def compare(self, i):
        print 'diff ' + self.tmpPath + '/tempOut ' + self.inputPath \
            + self.soal + '_' + str(i) + ' > ' + self.tmpPath + 'tmpLog'

        returnStat = 0
        p = 0
        toll = open(paths.tollerancepath + self.soal, 'r')
        try:
            p = float(toll.read())
        except ValueError:
            print 'exception'
        toll.close()
        if p == 0:
            returnStat = os.system('diff ' + self.tmpPath + '/tempOut '
                                   + self.inputPath + self.soal + '_'
                                   + str(i))
        else:
            returnStat = os.system('python ./custdiff.py '
                                   + self.tmpPath + '/tempOut '
                                   + self.inputPath + self.soal + ' '
                                   + str(p))
        if returnStat == 0:
            print returnStat
            self.submit_log += '7 '
            self.ac_count += 1
            logs = open(Compiler.log, 'a')
            logs.write('running ' + self.hashcode + ' ' + self.filename
                       + '.' + self.filetype + ' ' + self.user + ' '
                       + self.soal + ' testcase' + str(i)
                       + ' SUKSES, AC\n')
            logs.close()
            print 'Sukses'
            # cursor = self.db.cursor()
            # sql = \
            #     "select persentase from pc_testcase where inputcase = 'testCase" \
            #     + str(self.soal) + '_' + str(i) + "'"
            # cursor.execute(sql)
            # results = cursor.fetchall()
            # for row in results:
            #     print row[0]
            #     self.total = self.total + int(row[0])
        else:
            print returnStat
            returnStat = os.system('diff -iwB ' + self.tmpPath
                                   + '/tempOut ' + self.inputPath
                                   + self.soal + '_' + str(i))
            if returnStat == 0:
                self.submit_log += '8 '
                self.status_log = '.6.'
                logs = open(Compiler.log, 'a')
                logs.write('running ' + self.hashcode + ' '
                           + self.filename + '.' + self.filetype + ' '
                           + self.user + ' ' + self.soal + ' testcase'
                           + str(i) + ' GAGAL, Presentation Error\n')
                logs.close()
                print 'presentation error'
            else:
                self.submit_log += '9 '
                self.status_log = '.1.'
                logs = open(Compiler.log, 'a')
                logs.write('running ' + self.hashcode + ' '
                           + self.filename + '.' + self.filetype + ' '
                           + self.user + ' ' + self.soal + ' testcase'
                           + str(i) + ' GAGAL, Wrong Answer\n')
                logs.close()
                print 'gagal'

    def mle(self, i):
        self.submit_log += '3 '
        self.status_log = '.5.'
        logs = open(Compiler.log, 'a')
        logs.write('running ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' testcase' + str(i)
                   + ' GAGAL, Memory Limit Exceeded\n')
        logs.close()
        print 'mle'

    def tle(self, i):
        self.submit_log += '5 '
        self.status_log = '.4.'
        logs = open(Compiler.log, 'a')
        logs.write('running ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' testcase' + str(i)
                   + ' GAGAL, Time Limit Exceeded\n')
        logs.close()
        print 'tle'

    def rte(self, i):
        self.submit_log += '6 '
        self.status_log = '.3.'
        logs = open(Compiler.log, 'a')
        logs.write('running ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' testcase' + str(i)
                   + ' GAGAL, Runtime Error\n')
        logs.close()
        print 'rte'

    def ce(self):
        logs = open(Compiler.log, 'a')
        status = open(paths.rootCompilerPath + 'status/' + self.waktu
                      + '.' + self.hashcode + '.0.2.2', 'w')
        status.close()
        logs.write('kompilasi ' + self.hashcode + ' ' + self.filename
                   + '.' + self.filetype + ' ' + self.user + ' '
                   + self.soal + ' GAGAL, COMPILE ERROR\n')
        logs.close()
        print 'ce'
