clear
ulimit -v $1
ulimit -m 
ulimit -a 
$2 < $3
echo $? > value
