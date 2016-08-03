#!/bin/bash

inotify_file=$1
pxe_boot=$2

inotifywait -m  --fromfile $inotify_file -e MOVED_TO -e CLOSE_WRITE |  while read DIR EVENT FILE; do
	if [ "$FILE" = "dom0-vgt" -o "$FILE" = "xen.gz" -o "$FILE" = "initrd-vgt.img" ]; then
		\cp $DIR$FILE $pxe_boot
	fi
done
