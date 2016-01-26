#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

int main (int argc, char *argv[])
{
  setuid (0);

  /* WARNING: Only use an absolute path to the script to execute,
  *          a malicious user might fool the binary and execute
  *          arbitary commands if not.
  * */

  system ("kill -9 $(ps aux | grep 'bots.py' | grep -v grep | awk '{print $2}')");
  system ("kill -9 $(ps aux | grep 'rejudge.py' | grep -v grep | awk '{print $2}')");
  system ("kill -9 $(ps aux | grep 'main.py' | grep -v grep | awk '{print $2}')");

  return 0;
}
