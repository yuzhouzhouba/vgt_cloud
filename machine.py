#!/usr/bin/python

import yaml
import class_powerc
import os,sys,time,signal,shutil

yaml_file = sys.argv[1]
inotify_file = yaml_file + "watch"
pid_file = yaml_file + "pid"

stream = file( yaml_file, 'r')
yamldic = yaml.load(stream)

TFTP_FOLDER = '/tftpboot'
REMOTE_FS = '/remote_fs'

machine = yamldic['machine']
comip = yamldic['comip']
vnc = yamldic['vnc']
mac_address = yamldic['mac']
ip = yamldic['ip']
status = yamldic['status']
xen_para = yamldic['xenc']
kernel_para = yamldic['kernel']
boot_type = yamldic['type']
user = yamldic['user']

nfs_server = '192.168.79.188'

class PXE:
    def __init__(self):
        self.mac=None
        self.pxeconfig=None
        self.tftp_path=TFTP_FOLDER
    def set_mac(self, mac_address):
        self.mac='01-' + mac_address.replace(':','-').lower()
        self.mac_address=mac_address
    def prepare_pxe_boot(self):
        fd=open(self.pxeconfig,'w+')
        osditem='ubuntu'
	if boot_type == 'kvmgt':
        	fd.write("""default %s
prompt 1
timeout 5

display boot.msg

label local
localboot 0

label %s""" % (osditem, osditem))

	        fd.write("""
kernel installer/x86_64/ubuntu/%s/dom0-vgt
append initrd=installer/x86_64/ubuntu/%s/initrd-vgt.img root=/dev/nfs boot=nfs rw  ip=dhcp nfsroot=%s:/remote_fs/%s %s""" % (machine, machine, nfs_server, user, kernel_para.strip('\n')))
	else:
	     fd.write("""default %s
prompt 1
timeout 5

display boot.msg

label local
localboot 0

label %s""" % (osditem, osditem))

             fd.write("""
kernel installer/x86_64/ubuntu/%s/mboot.c32
append installer/x86_64/ubuntu/%s/xen.gz %s --- installer/x86_64/ubuntu/%s/dom0-vgt boot=nfs rw  ip=dhcp nfsroot=%s:/remote_fs/%s %s --- installer/x86_64/ubuntu/%s/initrd-vgt.img""" % (machine, machine, xen_para.strip('\n'), machine, nfs_server, user, kernel_para.strip('\n'), machine))
	
        return True

    def prepare_boot_file(self):
        return True

    def pxe_post_boot(self, sleep_time):
        time.sleep(int(sleep_time))
        print "Change PXE boot option to local"
        os.system("sed -i 's/default.*/default local/' %s" % self.pxeconfig)
        return True

    def start_pxe(self, powerc):
        self.pxeconfig=self.tftp_path + '/pxelinux.cfg/' + self.mac
        config_folder = os.path.dirname(self.pxeconfig)
        if not os.path.isdir(config_folder):
            os.makedirs(config_folder)
        retval=self.prepare_boot_file()
        if not retval:
            print "Prepare kernel boot file fail"
            return False
        retval=self.prepare_pxe_boot()
        if not retval:
            print "Prepare PXE configuration file fail"
            return False
        if not powerc.reboot(self.mac_address):
            print "Reboot $s fail" % (self.mac_address)
            return False
        sleep_time=600
        power_method=''
        try:
            power_method=powerc.get_power_method(self.mac_address)
            if power_method == 'powerswitch':
                sleep_time=0
            else:
                sleep_time=powerc.get_cold_boot_time(self.mac_address)
        except:
            print "Get time of PXE exception"
        #self.pxe_post_boot(sleep_time)
        return True


if __name__ == '__main__':
	if status == 'unavailable':
	    print "The machine is unavailable"
            sys.exit(1)
	if not os.path.exists(REMOTE_FS):
	    os.mkdir(REMOTE_FS)
	    os.system('mount %s:/%s %s' % (nfs_server, REMOTE_FS, REMOTE_FS))
	elif not os.path.ismount(REMOTE_FS):
	    os.system('mount %s:%s %s' % (nfs_server, REMOTE_FS, REMOTE_FS))
	if not os.path.exists('%s/%s' % (REMOTE_FS, user)):
	    os.system('cp -fr %s/base %s/%s' % (REMOTE_FS, REMOTE_FS, user))
	    #shutil.copytree('%s/base' % (REMOTE_FS), '%s/%s' % (REMOTE_FS, user))

	if os.path.exists(pid_file):
	    fa=open(pid_file, "r")
            pid=fa.read()
	    if pid is None:
	        os.kill(pid, signal.SIGKILL)
	    os.remove(pid_file)

	fd=open( inotify_file, "w")
	fd.write('/remote_fs/%s/boot/\n' % (user))
	fd.close()
	os.system("inotify.sh '%s' '/tftpboot/installer/x86_64/ubuntu/%s/' &" % (inotify_file, machine))
	fs=os.popen("ps -ef | grep [Ii]notifywait | grep %s|awk '{print $2}'" %(inotify_file))
	pid=fs.read()
	fw=open(pid_file, "w")
	fw.write(pid)
	fw.close()
	#else:
	#    os.system('rm -fr /tftpboot/installer/x86_64/ubuntu/%s/dom0-vgt' % (machine))
	#    os.system('rm -fr /tftpboot/installer/x86_64/ubuntu/%s/initrd-vgt.img' % (machine))
	#    os.system('rm -fr /tftpboot/installer/x86_64/ubuntu/%s/xen.gz' % (machine))
	    #os.symlink('%s/%s/boot/dom0-vgt' % (REMOTE_FS, user), '/tftpboot/installer/x86_64/ubuntu/%s/dom0-vgt' % (machine))
	    #os.symlink('%s/%s/boot/initrd-vgt.img' % (REMOTE_FS, user), '/tftpboot/installer/x86_64/ubuntu/%s/initrd-vgt.img' % (machine))
	    #os.symlink('%s/%s/boot/xen.gz' % (REMOTE_FS, user), '/tftpboot/installer/x86_64/ubuntu/%s/xen.gz' % (machine))
	powerc = class_powerc.PowerControl()
	pxe = PXE()
	pxe.set_mac(mac_address)	
	pxe.start_pxe(powerc)
