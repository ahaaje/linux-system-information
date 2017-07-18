Linux System Information
=========================

This is a light-weight library to gather information (stats) about the Linux system it is running on.

The information is read from the files in /proc/* and /etc/*. These are usually world readable, but your system may vary. There is no dependency on `system` or `exec`calls to binaries installed on your system.


Features
--------

* PSR-4 autoloading compliant structure
* Example file

Stats that can be fetched
-------------------------
- hostname
- load average (for 1, 5 or 15 minutes)
- memory, as total, available and used
