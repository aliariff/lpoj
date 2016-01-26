#/bin/python
#import math
import sys
file1 = sys.argv[1]
file2 = sys.argv[2]
delta = float(sys.argv[3])
f1 = open(file1,"r")
f2 = open(file2,"r")
isi1 = f1.read().split("\n")
try:
	isi1.remove('')
except ValueError:
	print "catching exception"
print isi1
isi2 = f2.read().split("\n")
try:
	isi2.remove('')
except ValueError:
	print "catching exception"
print isi2
if len(isi1)!=len(isi2):
	print "panjang ile tidak sama"
	sys.exit(1)
for i in range(len(isi1)-1):
	h1 = float(isi1[i])
	h2 = float(isi2[i])
	if(abs(h1-h2)>delta):
		print "panjang delta terlalu besar "+str(abs(h1-h2))
		sys.exit(1)
sys.exit(0)
