#============================================================================
# This library is free software; you can redistribute it and/or
# modify it under the terms of version 2.1 of the GNU Lesser General Public
# License as published by the Free Software Foundation.
#
# This library is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# Lesser General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public
# License along with this library; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#============================================================================
# Copyright (C) 2007 Yongkang You <yongkang.you@intel.com>
#============================================================================

# This is to integrate powerman control.
# It is need to deal with exceptions by UP caller, 
#   because power operation might fail.

import sys,os,string
import time,sys
import threading
import xmlrpclib
import SimpleXMLRPCServer
#from oti.common.lab_common import *
#from common import *

#power control command
powerman='/usr/bin/powerman'
powermand='/etc/init.d/powerman'
POWER_METHOD_CONF= 'conf/power_method.conf'
#define semaphore
ps_sem=threading.Semaphore()

class PowerControl:
    global ps_sem

    def __init__(self):
        #start powerman daemon
        try:
            time.sleep(5)
            ret_val=self.powermand_restart()
        finally:
            return

    def get_power_method(self, node_name):
        method="powerswitch"
        return method
 
    def get_ip_list(self, node_name):
        ip_list = [] 
        hostname = None
        lines = open(POWER_METHOD_CONF, 'r').readlines()
        for line in lines:
            if (line.find(node_name) >= 0):
                try:
                    if line[0] == "#":
                        continue
                    else:
                        #powerip = line.strip().split()[3]
                        hostname = line.strip().split()[0]
                        #print "node %s use powerip=%s to control the power" % (node_name, powerip)
                        break
                except:
                    print "exception happens: %s" % line

        if not hostname:
             print "Did not find the hostname for the required machine: %s" % node_name
             return ip_list

        for line in lines:
            if (line.find(hostname) >= 0):
                try:
                    if line[0] == "#":
                        continue
                    else:
                        ip_list.append(line.strip().split()[3])
                except:
                    print "exception happens: %s" % line

        return ip_list

    def get_power_ctrl_ip(self, power_method, ip_list):
        #test which IP is used to remote power access 
        power_ctrl_ip = None
        old_dir=os.getcwd()
        os.chdir(PYAMT_PATH)
        for ip in ip_list:
            if (power_method == "amt"):
                #cmd = "ping %s -c 5" % ip
                cmd = PYAMT % (ip, AMT_USER, AMT_PWD, 'PowerDown')
            elif (power_method == "ipmi"):
                cmd = PYIPMI % (ip, 'status')

            for times in range(3):
                try:
                    ret = os.system(cmd)
                except:
                    print "try another times"
                    time.sleep(10)
                    continue
                if (ret == 0):
                    power_ctrl_ip = ip
                    break
            if power_ctrl_ip:
                break

        os.chdir(old_dir)
        return power_ctrl_ip 

    def powermand_restart(self):
        """
            It is better to restart powerman service, before execute command.
            Or the 2nd operation would be time_out.
        """
        if not os.path.isfile(powermand):
            return False
 
        ps_sem.acquire()
        ret_val=os.system('%s stop' % (powermand))#hiddent threats of errors should be handled seperately or by exceptions
        ret_val=os.system('%s start' % (powermand))
        ps_sem.release()

        if (ret_val != 0):
            print "powerman daemon start fail"
            #raise "Powerman Daemon Start Fail!"
        #Add a time break
        time.sleep(1)
        return not ret_val

    def poweron(self, node_name):
        print "Check power method of node_name: %s" % (node_name)
        method=self.get_power_method(node_name)
        ip_list = self.get_ip_list(node_name)
        #if not method or not powerip: 
        if ((not method) or (len(ip_list) == 0)):
            return False

        if (method == 'amt'  or  method == 'ipmi'):
            try:
                powerip = self.get_power_ctrl_ip(method, ip_list)
                if not powerip:
                    return False
            except:
                print "Get work IP exceptiion"
                return False
                       
        #Use AMT to power on
        if method == 'amt':
            old_dir=os.getcwd()
            os.chdir(PYAMT_PATH)
            print "use AMT to power on target (ip=%s): " % powerip
            cmd=PYAMT % (powerip, AMT_USER, AMT_PWD, 'Reset')
            print cmd
            ret_str = os.popen(cmd, 'r').read()
            if (ret_str.find('Success')<0):
                print "can't Reset target(ip=%s),maybe target is " \
                                                    % powerip,
                print "at poweroff state, try PowerUp"
                time.sleep(1)
                cmd=PYAMT % (powerip, AMT_USER, AMT_PWD, 'PowerUp')
                print cmd
                ret_str = os.popen(cmd, 'r').read()             
            os.chdir(old_dir)
            if (ret_str.find('Success')<0):
                print "power on target(ip=%s) using AMT: fail" % powerip
                #raise "power on target(ip=%s) using AMT: fail" % powerip
                return False
            else:
                print "power on target(ip=%s) using AMT: succeed" % powerip
                return True
 
        if method == 'ipmi':
             print "use ipmi to power on target (ip=%s): " % powerip
             getpowercmd=PYIPMI % (powerip, "status")
             ret_str = os.popen(getpowercmd,'r').read() 
             if (ret_str.find('off')>0):
                 cmd=PYIPMI % (powerip, 'on')
             else:
                 cmd=PYIPMI % (powerip, 'cycle')
             print cmd
             try:
                 ret_val = os.system(cmd)
                 if (ret_val != 0 ):
                     print "power on target(ip=%s) using IPMI: fail" % powerip
                     #raise "power on target(ip=%s) using IPMI: fail" % powerip
                     return False
                 else:
                     print "power on target(ip=%s) using IPMI: succeed" %powerip
                     return True
             except:
                 print "power on target(ip=%s) using IPMI: fail" % powerip
                 #raise "power on target(ip=%s) using IPMI: fail" % powerip
                 return False
        print "use powerswitch to poweron %s" % node_name
        try:
            self.powermand_restart()
            ret_val=os.system('%s -1 %s' % (powerman, node_name))
            if (ret_val != 0):
                print "power on target node: %s fail" % (node_name)
                print "Try again."
                self.powermand_restart()
                ret_val=os.system('%s -1 %s' % (powerman, node_name))
                if (ret_val != 0):                
                    print "power on target node: %s fail again" % (node_name)
                    #raise "powerman poweron target node: %s fail" % (node_name)
                    return False
        #finally:
        #    return True
        except:
             print "power on target node: %s exception" % (node_name)
             return False

        return True
        
    def poweroff(self, node_name):
        print "Check power method of node_name: %s"% (node_name)
        method=self.get_power_method(node_name)

        print "use powerswitch to poweroff %s" % node_name         
        try:
            self.powermand_restart()
            ret_val=os.system('%s -0 %s' % (powerman, node_name))
            if (ret_val != 0):
                print "power off target node: %s fail" % (node_name)
                print "Try again."
                self.powermand_restart()
                ret_val=os.system('%s -0 %s' % (powerman, node_name))
                if (ret_val != 0):                
                    print "power off target node: %s fail again" % (node_name)
                    #raise "powerman off target node: %s fail" % (node_name)
                    return False
        #finally:
        #    return True
        except:
             print "power off target node: %s exception" % (node_name)
             return False

        return True

    def reboot(self, node_name, delay=0):
        #add for special requirement about delaying reboot.
        time.sleep(delay)
        print "get the power method of node_name : %s" % (node_name)
        method=self.get_power_method(node_name)
        print "get the power method of node_name : %s" % (method)

        print "use powerswitch to reboot %s" % node_name
        if method == 'powerswitch':
            try:
                self.powermand_restart()
                #ret_val=os.system('%s -0 %s;sleep 3' % (powerman, node_name))
                #self.powermand_restart()
                #ret_val=os.system('%s -1 %s' % (powerman, node_name))
                ret_val = os.system('%s --reset %s' % (powerman, node_name))
            except:
                print "power reset target node: %s exception" % (node_name)

            #reboot machine successfully
            return True
        else:
            print "No such power method %s" % method

        return True


#pc=PowerControl()
#pc.poweron('192.168.1.1', True)
